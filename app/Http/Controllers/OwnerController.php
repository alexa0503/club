<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\DiscuzHelper;
use DB;
use Validator;

class OwnerController extends Controller
{
    public function verify(Request $request)
    {
        $request->merge(array_map('trim', $request->all()));
        $messages = [
            'frame_number.required' => '请填写8位数字加英文车架号',
            'frame_number.regex' => '请填写8位数字加英文车架号',
            //'frame_number.unique' => '该车架号已经被使用过了',
            'id_card.required' => '必须填写身份证号',
        ];
        $validator = Validator::make($request->all(), [
            'frame_number' => [
                'required',
                //'unique:verifies,frame_number',
                'regex:/^[a-z0-9A-Z]{8}$/'
            ],
            'id_card' => 'required',
        ], $messages);
        $validator->after(function ($validator) use($request) {
            $frame_number = $request->frame_number;
            $count = \App\Verify::where('frame_number','like','%'.$frame_number)->count();
            if( $count > 0){
                $validator->errors()->add('frame_number', '该车架号已经被使用过了');
            }

            /*
            $options = [
                'frame_number'=>$request->frame_number,
                'id_card'=>$request->id_card,
                'register_date'=>date('Y-m-d H:i:s'),
                'type'=>'1',
            ];
            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY01SOAP?wsdl");
            $options = [
                'in'=>json_encode($options),
            ];
            $response = $client->__soapCall("Hy01", array($options));
            $result = json_decode($response->out,true);
            //var_dump($result);
            if( !$result || $result['ret']!= 0){
                $validator->errors()->add('frame_number', '车架号或身份证输入错误，请重新填写。');
                //return response(['ret'=>1001,'msg'=>'车架号或身份证输入错误，请重新填写。']);
            }
            */
        });

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $options = [
            'frame_number'=>$request->frame_number,
            'id_card'=>$request->id_card,
            'register_date'=>date('Y-m-d H:i:s'),
            'type'=>'1',
        ];
        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY01SOAP?wsdl");
        $options = [
            'in'=>json_encode($options),
        ];
        $response = $client->__soapCall("Hy01", array($options));
        $result = json_decode($response->out,true);
        if( !$result || $result['ret']!= 0){
            return response(['ret'=>1001,'msg'=>'车架号或身份证输入错误，请重新填写。']);
        }

        $frame_number = $result['vin'];

        $uid = session('discuz.user.uid');
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
            'dateline'=>time(),
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
        if( env('APP_ENV') != 'local'){
            $key = env('DISCUZ_UCKEY');
            $fromuid = 1;
            $timestamp = time();
            $msgto = $uid;
            $subject = '车主验证成功';
            $message = '恭喜您，车主验证成功，你获取了积分与风迷币奖励。奖励如下：'.$credits1.' 积分，'.$credits4.'风迷币。';
            $url = env('APP_URL').'/bbs/api/uc.php?time='.$timestamp.'&code='.urlencode(DiscuzHelper::authcode("action=sendpm&fromuid=".$fromuid."&msgto=".$msgto."&subject=".$subject."&message=".$message."&time=".$timestamp, 'ENCODE', $key));
            $client = new \GuzzleHttp\Client();
            $client->request('GET', $url);
        }
        return response(['ret'=>0,'msg'=>'车主验证成功。']);
    }
    public function verifyLogs()
    {
        $uid = session('discuz.user.uid');
        $verifies = \App\Verify::where('uid', $uid)->get();
        return view('mall.verify_logs',[
            'verifies'=>$verifies
        ]);
    }
    public function update()
    {
        $uid = session('discuz.user.uid');
        $verifies = \App\Verify::where('uid',$uid)->where('status','>=',0)->get();

        foreach($verifies as $verify){
            $frame_number = $verify->frame_number;//车架号

            $_log = \App\OwnerLog::where('verify_id', $verify->id)->where('generate_way',1)->orderBy('score_id','DESC')->first();
            if( $_log == null ){
                $score_id = 0;
            }
            else{
                $score_id = $_log->score_id;
            }
            //新增积分
            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY02SOAP?wsdl");
            $options = [
                'in'=>json_encode([
                    'frame_number'=>$frame_number,
                    'score_id' => $score_id,
                ])
            ];
            $response = $client->__soapCall("queryPartsInfo", array($options));
            $result = json_decode($response->out,true);
            //var_dump($result);
            if($result && $result['ret'] == 0 && isset($result['data']) && is_array($result['data'])){
                foreach ($result['data'] as $data){
                    $count = \App\OwnerLog::where('score_id', $data['SCORE_ID'])->count();
                    if( $count > 0 ){
                        continue;
                    }
                    $data['title'] = '车主奖励';
                    $data['generate_way'] = 1;
                    $data['verify_id'] = $verify->id;
                    \App\Helpers\Helper::updateLog($uid,$data);
                }
            }

            //工单取消
            $_log = \App\OwnerLog::where('verify_id', $verify->id)->where('generate_way',2)->orderBy('score_id','DESC')->first();
            if( $_log == null ){
                $score_id = 0;
            }
            else{
                $score_id = $_log->score_id;
            }
            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY05SOAP?wsdl");
            $options = [
                'in'=>json_encode([
                    'frame_number'=>$frame_number,
                    'score_id' => $score_id,
                ])
            ];
            $response = $client->__soapCall("CancelOrderAccount", array($options));
            $result1 = json_decode($response->out,true);
            //var_dump($result1);
            if($result1 && $result1['ret'] == 0 && isset($result1['data']) && is_array($result1['data'])){
                foreach ($result1['data'] as $data){
                    $count = \App\OwnerLog::where('score_id', $data['SCORE_ID'])->count();

                    if( $count > 0 ){
                        continue;
                    }
                    $data['title'] = '车主工单取消';
                    $data['generate_way'] = 2;
                    $data['verify_id'] = $verify->id;
                    \App\Helpers\Helper::updateLog($uid,$data);
                    \App\OwnerLog::where('rono', $data['Rono'])->where('generate_way','1')->delete();
                }
            }
            //$verify->status = 1;
            //$verify->save();
        }
        return response('',200);
    }
    public function reference(Request $request)
    {
        $messages = [
            'frame_number.required' => '请填写8位数字加英文车架号',
            'frame_number.regex' => '请填写8位数字加英文车架号',
            'frame_number.unique' => '该车架号已经推荐过了',
            'username.required' => '必须填写推荐用户名',
            'username.exists' => '推荐的用户名不存在哦',
        ];
        $validator = Validator::make($request->all(), [
            'frame_number' => [
                'required',
                'unique:references,frame_number',
                'regex:/^[a-z0-9A-Z]{8}$/'
            ],
            'username' => 'required|exists:discuz_common_member,username',
        ], $messages);


        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }
        $reference = new \App\Reference;
        $reference->frame_number = $request->frame_number;
        $reference->username = $request->username;
        $reference->uid = session('discuz.user.uid');
        $reference->save();
        return ['ret'=>0, 'msg'=>'信息提交成功，我们会在审核后通知您~'];
    }
}
