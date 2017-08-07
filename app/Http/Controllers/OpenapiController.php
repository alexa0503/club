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
        if(strpos("register",\Route::current()->getActionName()) !== false){
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
	}


	public function getUserinfo(Request $request){
        $info = DB::table("verifies as a")
            ->leftJoin("discuz_common_member_count as b","b.uid","=","a.uid")
            ->leftJoin("discuz_common_member as c","c.uid","=","a.uid")
            ->leftJoin("discuz_common_usergroup as d","d.groupid","=","c.groupid")
            ->where("a.frame_number","=",$request->Vin)
            ->select("a.uid","b.extcredits1","b.extcredits4","c.groupid","d.grouptitle")
            ->first();
        /*$info = DB::select("select a.uid,b.extcredits1,b.extcredits4,
            CASE groupid 
            WHEN 11 THEN '银牌'
            WHEN 12 THEN '金牌'
            WHEN 13 THEN '铂金'
            WHEN 14 THEN '钻石'
            ELSE '铜牌'
            END as groupname
            from verifies a,discuz_common_member_count b,discuz_common_member c 
            where a.frame_number='{$request->vin}' and a.uid=c.uid and a.uid=b.uid
            limit 1");*/
            if($info){
                $this->jsond(1,"SUCC",$info);
            }else{
                $this->jsond(0,"ERROR");
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

    public function register(Request $request){
        //$uid = INSERT INTO discuz_ucenter_members username='$username', password='$password', email='$email', regip='$regip', regdate='$regdate', salt='$salt'
        //INSERT INTO discuz_ucenter_memberfields SET uid='$uid'
        //C::t('common_member')->insert($uid, $username, $password, $email, $_G['clientip'], $groupinfo['groupid'], $init_arr);
        //print_r($request->all());die;
        $messages = [
            'username.required' => '用户名不能为空',
            'username.min' => '用户名长度必须大于3位',
            'username.alpha_dash' => '用户名格式错误，只能包含字母、数字、破折、号以及下划线',
            'username.unique' => '用户名已经存在',

            'password.required' => '密码不能为空',
            'password.min' => '密码长度必须大于6位',
            'password.alpha_dash' => '密码格式错误，只能包含字母、数字、破折、号以及下划线',
            'password.confirmed' => '两次密码输入不一致',

            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式错误',
            'email.unique' => '邮件已经存在',

            'regip.required' => 'ip不能为空',
            'regip.ip' => 'ip格式错误',
        ];
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:3|alpha_dash|unique:discuz_ucenter_members',
            'password' => 'required|min:6|alpha_dash|confirmed',
            'email' => 'required|email|unique:discuz_ucenter_members',
            'regip' => 'required|ip',
        ], $messages);
        //print_r($validator->errors()->first());die;
        if ($validator->fails()) {
            $this->jsond(0,$validator->errors()->first());
        }

        $username = $request->username;
        $salt = substr(uniqid(rand()), -6);
        $password = md5(md5($request->password).$salt);
        $email = $request->email;
        $regip = $request->regip;
        $regdate = $this->timestamp;
        $groupid = 10;

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
        $this->jsond(1,"注册成功",array("uid"=>$uid));
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



	public function jsond($result, $msg="", $info = array()){
		echo json_encode(array("result"=>$result,"msg"=>$msg,"info"=>$info));
		exit;
	}
}