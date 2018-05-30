<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\DiscuzHelper;
use DB;
use Validator;

class OpenapiController extends Controller{

    public $timestamp;

	public function __construct(Request $request){
        //echo \Route::current()->getActionName();die;
        $this->timestamp = time();
        $request->merge(array_map('trim', $request->all()));

        $messages = [
            'Vin.required' => '参数不能为空',
            'Vin.regex' => '格式错误',
        ];
        $validator = Validator::make($request->all(), [
            'Vin' => [
                'required',
                'regex:/^[a-z0-9A-Z]{17}$/',
            ],
        ], $messages);

        if ($validator->fails()) {
            $this->jsond(0,$validator->errors()->first());
        }
	}


	public function getUserinfo(Request $request){
        $info = $this->userinfo($request);
        if($info){
            if($info->status >= 0){
                $this->jsond(1,"SUCC",$info);
            }else{
                $this->jsond(0,"该车架号已退车",array());
            }
        }

        //没有数据，自动注册
        $messages = [
            'id_card.required' => '参数不能为空',
        ];
        $validator = Validator::make($request->all(), [
            'id_card' => [
                'required',
            ],
        ], $messages);

        if ($validator->fails()) {
            $this->jsond(0,$validator->errors()->first());
        }
        $Vin = substr($request->Vin,-8);
        //根据vin和id_card获取车型
        $options = [
            'frame_number'=>$Vin,
            'id_card'=>$request->id_card,
            'register_date'=>$this->timestamp,
            'type'=>'1',
        ];
        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY01SOAP?wsdl");
        $options = [
            'in'=>json_encode($options),
        ];
        $response = $client->__soapCall("Hy01", array($options));
        $result = json_decode($response->out,true);
        //print_r($result);die;
        if( !$result || $result['ret']!= 0){
            $this->jsond(0,"车架号或身份证输入错误，请重新填写。");
        }

        $frame_number = $result['vin'];
        //vin后8位为用户名，密码统一为123456
        $request->username = $Vin;
        $request->password = "123456";
        $uid = $this->register($request);
        //记录认证信息register
        $veirfy = new \App\Verify();
        $veirfy->uid = $uid;
        $veirfy->frame_number = $frame_number;
        $veirfy->id_card = $request->id_card;
        $model_code = $veirfy->model_code = \App\Helpers\Helper::replaceCarModel($result['modelCode']);
        $veirfy->save();

        $user_count = \App\UserCount::where('uid',$uid)->first();
        $credits1 = \App\Helpers\Helper::getCreditsFromCarModel($model_code);
        $credits4 = 0;

        $user_count->extcredits1 += $credits1;
        $user_count->extcredits4 += $credits4;
        //print_r($user_count);die;
        //更新积分
        DB::table('discuz_common_member_count')
            ->where('uid',$uid)
            ->update([
                'extcredits1' => $user_count->extcredits1,
                'extcredits4' => $user_count->extcredits4,
            ]);
        $logid = DB::table('discuz_common_credit_log')->insertGetId([
            'uid' => $uid,
            'operation'=>'',
            'relatedid'=>$uid,
            'dateline'=>$this->timestamp,
            'extcredits1'=>$credits1,
            'extcredits4'=>$credits4,
            'extcredits2'=>0,
            'extcredits3'=>0,
            'extcredits5'=>0,
            'extcredits6'=>0,
            'extcredits7'=>0,
            'extcredits8'=>0,
        ]);
        //插入日志
        DB::table('discuz_common_credit_log_field')->insert([
            'logid'=>$logid,
            'title'=>'车主认证',
            'text'=>'车主认证通过奖励',
        ]);

        $verifies = \App\Verify::where('status','>=',0)->where('uid', $uid)->get();
        DiscuzHelper::checkUserGroup($uid);//更新用户等级
        $user = \DB::table('discuz_common_member')
            ->join('discuz_common_usergroup','discuz_common_member.groupid','=','discuz_common_usergroup.groupid')
            ->select('discuz_common_member.groupid','discuz_common_usergroup.grouptitle')
            ->where('uid',$uid)->first();
        switch ($user->groupid){
            case 11:
                //$member_level = '银牌';
                $multiple = 1;
                break;
            case 12:
                //$member_level = '金牌';
                $multiple = 1.2;
                break;
            case 13:
                //$member_level = '铂金';
                $multiple = 1.5;
                break;
            case 14:
                //$member_level = '钻石';
                $multiple = 2;
                break;
            default:
                //$member_level = '铜牌';
                $multiple = 1;
        }
        $member_level = $user->grouptitle;
        $user_count = \DB::table('discuz_common_member_count')->where('uid', $uid)->first();
        foreach($verifies as $verify){
            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY03?wsdl");
            $options = [
                'json'=>json_encode([
                    'vin'=>$verify->frame_number,
                    'member_level'=>$member_level,
                    'multiple'=>$multiple,
                    'total_scores'=>$user_count->extcredits1,
                    'total_fmb'=>$user_count->extcredits4,
                ])
            ];
            $response = $client->__soapCall("addMemberLevelInfo", array($options));
        }

        //发送消息
        /*if( env('APP_ENV') != 'local'){
            $key = env('DISCUZ_UCKEY');
            $fromuid = 1;
            $timestamp = $this->timestamp;
            $msgto = $uid;
            $subject = '车主验证成功';
            $message = '恭喜您，车主验证成功，你获取了积分与风迷币奖励。奖励如下：'.$credits1.' 积分，'.$credits4.'风迷币。';
            $url = env('APP_URL').'/bbs/api/uc.php?time='.$timestamp.'&code='.urlencode(DiscuzHelper::authcode("action=sendpm&fromuid=".$fromuid."&msgto=".$msgto."&subject=".$subject."&message=".$message."&time=".$timestamp, 'ENCODE', $key));
            $client = new \GuzzleHttp\Client();
            $client->request('GET', $url);
        }*/
        $info = $this->userinfo($request);
        $this->jsond(1,"SUCC",$info);
	}

    public function userinfo(Request $request){
        $info = DB::table("verifies as a")
            ->leftJoin("discuz_common_member_count as b","b.uid","=","a.uid")
            ->leftJoin("discuz_common_member as c","c.uid","=","a.uid")
            ->leftJoin("discuz_common_usergroup as d","d.groupid","=","c.groupid")
            ->where("a.frame_number","=",$request->Vin)
            ->select("a.uid","a.status","b.extcredits1","b.extcredits4","c.groupid","d.grouptitle","a.created_at")
            ->first();

        if($info){
            $len = 8 - strlen($info->uid);
            $uid = "";
            if($len > 0){
                for($i=0;$i<$len;$i++){
                    $uid .= "0";
                }
            }
            $info->uid = $uid.$info->uid;
        }
        return $info;
    }



    public function register(Request $request){
        //$uid = INSERT INTO discuz_ucenter_members username='$username', password='$password', email='$email', regip='$regip', regdate='$regdate', salt='$salt'
        //INSERT INTO discuz_ucenter_memberfields SET uid='$uid'
        //C::t('common_member')->insert($uid, $username, $password, $email, $_G['clientip'], $groupinfo['groupid'], $init_arr);
        //print_r($request->all());die;
        $username = $request->username;
        $salt = substr(uniqid(rand()), -6);
        $password = md5(md5($request->password).$salt);
        $email = $request->email;
        $regip = $request->regip;
        $regdate = $this->timestamp;
        $groupid = 11;//默认11
        $user = DB::table('discuz_ucenter_members')->select('uid')->where('username', $username)->first();
        if( $user != null ){
            $uid = $user->uid;
        }
        else{
            $uid = DB::table('discuz_ucenter_members')->insertGetId([
                'username' => (string) $username,
                'password'=>(string) $password,
                'email'=>(string) $email,
                'regip'=>(string) $regip,
                'regdate'=>(string) $regdate,
                'salt'=>$salt,
            ]);
            if(!$uid) $this->jsond(0,"注册失败");
            DB::table('discuz_ucenter_memberfields')->insert([
                'uid' => $uid,
                'blacklist' => ''
            ]);

            /*DB::table('common_member')->insert([
                'uid' => $uid,
                'username' => $username,
                'password'=>$password,
                'email'=>$email,
                'regip'=>$regip,
                'regdate'=>$regdate,
                'salt'=>$salt,
            ]);*/
            $init_arr = array('credits' => explode(',', "0,0,0,0,0,0,0,0,0"), 'profile'=>array(), 'emailstatus' => 0);
            $this->common_member_insert($uid, $username, $password, $email, $regip, $groupid, $init_arr);
        }
        return $uid;
    }


    public function common_member_insert($uid, $username, $password, $email, $ip, $groupid, $extdata, $adminid = 0) {
        if(($uid = intval($uid))) {

            $credits = isset($extdata['credits']) ? $extdata['credits'] : array();
            $profile = isset($extdata['profile']) ? $extdata['profile'] : array();
            $profile['uid'] = $uid;
            $profile['bio'] = "";
            $profile['interest'] = "";
            $profile['field1'] = "";
            $profile['field2'] = "";
            $profile['field3'] = "";
            $profile['field4'] = "";
            $profile['field5'] = "";
            $profile['field6'] = "";
            $profile['field7'] = "";
            $profile['field8'] = "";
            $base = array(
                'uid' => $uid,
                'username' => (string)$username,
                'password' => (string)$password,
                'email' => (string)$email,
                'adminid' => intval($adminid),
                'groupid' => intval($groupid),
                'regdate' => $this->timestamp,
                'emailstatus' => intval($extdata['emailstatus']),
                'credits' => intval($credits[0]),
                'timeoffset' => 9999
            );
            $status = array(
                'uid' => $uid,
                'regip' => (string)$ip,
                'lastip' => (string)$ip,
                'lastvisit' => $this->timestamp,
                'lastactivity' => $this->timestamp,
                'lastpost' => 0,
                'lastsendmail' => 0
            );
            $count = array(
                'uid' => $uid,
                'extcredits1' => intval($credits[1]),
                'extcredits2' => intval($credits[2]),
                'extcredits3' => intval($credits[3]),
                'extcredits4' => intval($credits[4]),
                'extcredits5' => intval($credits[5]),
                'extcredits6' => intval($credits[6]),
                'extcredits7' => intval($credits[7]),
                'extcredits8' => intval($credits[8])
            );
            $ext = array('uid' => $uid);
            DB::table('discuz_common_member')->insert($base, false, true);
            DB::table('discuz_common_member_status')->insert($status, false, true);
            DB::table('discuz_common_member_count')->insert($count, false, true);
            DB::table('discuz_common_member_profile')->insert($profile, false, true);
            DB::table('discuz_common_member_field_forum')->insert(array('uid' => $uid,"medals"=>"","sightml"=>"","groupterms"=>"","groups"=>""), false, true);
            DB::table('discuz_common_member_field_home')->insert(array('uid' => $uid,"spacecss"=>"","blockposition"=>"","recentnote"=>"","spacenote"=>"","privacy"=>"","feedfriend"=>"","acceptemail"=>"","magicgift"=>"","stickblogs"=>""), false, true);
            return true;
        }
    }

    public function getExtcredits1(Request $request){
        $info = DB::table("verifies as a")
            ->leftJoin("discuz_common_credit_log as b","b.uid","=","a.uid")
            ->leftJoin("discuz_common_credit_log_field as c","c.logid","=","b.logid")
            ->leftJoin("discuz_forum_activity as d","d.tid","=","b.relatedid")
            ->where("a.frame_number","=",$request->Vin)
            ->where("b.extcredits1","<>","0")
            ->select("b.extcredits1","b.operation","b.dateline","c.title","c.text","d.place","d.class")
            ->get();
        /*$info = DB::select("select a.uid,b.extcredits1,c.title,c.text
            from verifies a,discuz_common_credit_log b,discuz_common_credit_log_field c
            where a.frame_number='{$request->vin}' and a.uid=b.uid and b.logid=c.logid
            limit 1");*/
        if(!$info->isEmpty()){
            $this->jsond(1,"SUCC",$info);
        }else{
            $this->jsond(0,"ERROR");
        }
    }

    public function getExtcredits4(Request $request){
        $info = DB::table("verifies as a")
            ->leftJoin("discuz_common_credit_log as b","b.uid","=","a.uid")
            ->leftJoin("discuz_common_credit_log_field as c","c.logid","=","b.logid")
            ->leftJoin("discuz_forum_activity as d","d.tid","=","b.relatedid")
            ->where("a.frame_number","=",$request->Vin)
            ->where("b.extcredits4","<>","0")
            ->select("b.extcredits4","b.operation","b.dateline","c.title","c.text","d.place","d.class")
            ->get();
        /*$info = DB::select("select a.uid,b.extcredits1,c.title,c.text
            from verifies a,discuz_common_credit_log b,discuz_common_credit_log_field c
            where a.frame_number='{$request->vin}' and a.uid=b.uid and b.logid=c.logid
            limit 1");*/
        if(!$info->isEmpty()){
            $this->jsond(1,"SUCC",$info);
        }else{
            $this->jsond(0,"ERROR");
        }
    }

	public function jsond($result, $msg="", $info = array()){
		echo json_encode(array("result"=>$result,"msg"=>$msg,"info"=>$info));
		exit;
	}
  //积分新增或者消耗
  public function updateCredits(Request $request)
  {
    $key = '5abdeadc74b73';
    //return md5('LVZA53P94GC578465'.$key.'1503855231');
    //1503855231,655b6abd883dedd4183de6827b46ef94
    //http://club.dev/openapi/credits/update?Vin=LVZA53P94GC578465&timestamp=1503855231&credits1=100&credits4=200&sign=655b6abd883dedd4183de6827b46ef94
    $verify = \App\Verify::where('frame_number', $request->Vin)->first();
    if( null == $verify ){
      return ['result'=>0,'msg'=>'ERROR1','info'=>'不存在拥有此车架号的用户'];
    }
    if ( null == $request->timestamp || null == $request->sign ){
      return ['result'=>0,'msg'=>'ERROR2','info'=>'缺少参数'];
    }
    if( md5($request->Vin.$key.$request->timestamp) != $request->sign ){
      return ['result'=>0,'msg'=>'ERROR3','info'=>'请求验证失败'];
    }
    $uid = $verify->uid;
    $count =\DB::table('discuz_common_credit_log')->where('uid', $uid)->where('dateline',$request->timestamp)->count();
    if( $count > 0){
      return ['result'=>0,'msg'=>'ERROR4','info'=>'重复请求'];
    }
    $credits1 = $request->credits1 ? : 0;
    $credits4 = $request->credits4 ? : 0;
    $credits1 = (int)$credits1;
    $credits4 = (int)$credits4;
    $timestamp = $request->timestamp;
    $title = $request->title ? urldecode($request->title) : '积分奖惩';
    $text = $request->text ? urldecode($request->text) : '';
    if( $credits1 == 0 && $credits4 == 0){
      return ['result'=>0,'msg'=>'ERROR','info'=>'不存在拥有此车架号的用户'];
    }
    $user_count = \App\UserCount::where('uid',$uid)->first();
    $user_count->extcredits1 += $credits1;
    $user_count->extcredits4 += $credits4;
    //更新积分
    \DB::table('discuz_common_member_count')->where('uid',$uid)->update([
        'extcredits1' => $user_count->extcredits1,
        'extcredits4' => $user_count->extcredits4,
    ]);
    $logid = \DB::table('discuz_common_credit_log')->insertGetId([
        'uid' => $uid,
        'operation'=>'',
        'relatedid'=>$uid,
        'dateline'=>$timestamp,
        'extcredits1'=>$credits1,
        'extcredits4'=>$credits4,
        'extcredits2'=>0,
        'extcredits3'=>0,
        'extcredits5'=>0,
        'extcredits6'=>0,
        'extcredits7'=>0,
        'extcredits8'=>0,
    ]);
    //插入日志
    \DB::table('discuz_common_credit_log_field')->insert([
        'logid'=>$logid,
        'title'=>$title,
        'text'=> $text,
    ]);

    if( env('APP_ENV') != 'local'){
        $key = env('DISCUZ_UCKEY');
        $fromuid = 1;
        $timestamp = time();
        $msgto = $uid;
        $subject = $title;
        $message = '由于'.$text.'，详情如下：'.$credits1.' 积分，'.$credits4.'风迷币。';
        $url = env('APP_URL').'/bbs/api/uc.php?time='.$timestamp.'&code='.urlencode(DiscuzHelper::authcode("action=sendpm&fromuid=".$fromuid."&msgto=".$msgto."&subject=".$subject."&message=".$message."&time=".$timestamp, 'ENCODE', $key));
        $client = new \GuzzleHttp\Client();
        $client->request('GET', $url);
    }
    return response(['result'=>1,'msg'=>'SUCC']);
  }
}
