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
        $messages = [
            'frame_number.required' => '请填写17位数字加英文车架号',
            'frame_number.regex' => '请填写17位数字加英文车架号',
            'frame_number.unique' => '该车架号已经被使用过了',
            'id_card.required' => '必须填写身份证号',
        ];
        $validator = Validator::make($request->all(), [
            'frame_number' => [
                'required',
                'unique:verifies,frame_number',
                'regex:/^[a-z0-9A-Z]{17}$/'
            ],
            'id_card' => 'required',
        ], $messages);

        /*
        $validator->after(function ($validator) use($result) {
            if( !$result || $result['ret']!= 0){
                $validator->errors()->add('id_card', '车架号与身份证不匹配');
            }
        });
        */

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

        $uid = session('discuz.user.uid');
        $veirfy = new \App\Verify();
        $veirfy->uid = $uid;
        $veirfy->frame_number = $request->frame_number;
        $veirfy->id_card = $request->id_card;
        $veirfy->model_code = $result['modelCode'];
        $veirfy->save();

        $user_count = \App\UserCount::where('uid',$uid)->first();

        //$count = \App\Verify::where('uid', $uid)->count();
        switch (strtoupper($result['modelCode'])){
            case 'F507':
            case 'F507S':
                $credits1 = 4000;
                $credits4 = 0;
                break;
            case 'F506':
            case 'F506S':
                $credits1 = 2000;
                $credits4 = 0;
                break;
            default:
                $credits1 = 500;
                $credits4 = 0;
        }

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
        $user = \App\User::where('uid', $uid)->first();
        switch ($user->groupid){
            case 11:
                $member_level = '银牌';
                $multiple = 1;
                break;
            case 12:
                $member_level = '金牌';
                $multiple = 1.2;
                break;
            case 13:
                $member_level = '铂金';
                $multiple = 1.5;
                break;
            case 14:
                $member_level = '钻石';
                $multiple = 2;
                break;
            default:
                $member_level = '铜牌';
                $multiple = 1;
        }

        foreach($verifies as $verify){
            $frame_number = $verify->frame_number;//车架号
            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY03?wsdl");
            $options = [
                'json'=>json_encode([
                    'vin'=>$frame_number,
                    'member_level'=>$member_level,
                    'multiple'=>$multiple,
                ])
            ];
            $response = $client->__soapCall("addMemberLevelInfo", array($options));
            $result = json_decode($response->addMemberLevelInfoReturn,true);
           if( !$result || $result['ret'] != 0){
               continue;
           }

            //新增积分
            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY02SOAP?wsdl");
            $options = [
                'in'=>json_encode([
                    'frame_number'=>$frame_number,
                ])
            ];
            $response = $client->__soapCall("queryPartsInfo", array($options));
            $result = json_decode($response->out,true);

            if($result && $result['ret'] == 0 && isset($result['data']) && is_array($result['data'])){
                foreach ($result['data'] as $data){
                    $count = \App\OwnerLog::where('uid', $uid)
                        //->where('spent_at', $spent_at)
                        ->where('generate_way', 1)
                        //->where('reason', $data['Reason'])
                        ->where('score_id', $data['SCORE_ID'])
                        ->count();

                    if( $count > 0 ){
                        continue;
                    }

                    $data['title'] = '车主奖励';
                    $data['generate_way'] = 1;
                    $data['verify_id'] = $verify->id;
                    $this->updateLog($uid,$data);
                }
            }

            //工单取消
            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY05SOAP?wsdl");
            $options = [
                'in'=>json_encode([
                    'frame_number'=>$frame_number,
                ])
            ];
            $response = $client->__soapCall("CancelOrderAccount", array($options));
            $result1 = json_decode($response->out,true);
            //var_dump($result1);
            if($result1 && $result1['ret'] == 0 && isset($result1['data']) && is_array($result1['data'])){
                foreach ($result1['data'] as $data){

                    $count = \App\OwnerLog::where('uid', $uid)
                        //->where('spent_at', $spent_at)
                        ->where('generate_way', 2)
                        //->where('reason', $data['Reason'])
                        ->where('score_id', $data['SCORE_ID'])
                        ->count();

                    if( $count > 0 ){
                        continue;
                    }
                    $data['title'] = '车主工单取消';
                    $data['generate_way'] = 2;
                    $data['verify_id'] = $verify->id;
                    $this->updateLog($uid,$data);
                }
            }
            //$verify->status = 1;
            //$verify->save();
        }
        return response('',200);
    }
    protected function updateLog($uid,$data)
    {
        $spent_at = date('Y-m-d H:i:s',strtotime($data['spent_at']));
        if( $data['generate_way'] == 2 ){
            $credits1 = -1*$data['Point'];
            $credits4 = -1*$data['Coin'];
        }
        else{
            $credits1 = $data['Point'];
            $credits4 = $data['Coin'];
        }

        $log = new \App\OwnerLog();
        $log->verify_id = $data['verify_id'];
        $log->uid = $uid;
        $log->reason = \App\Helpers\Helper::replaceCarModel($data['Reason']);
        $log->point = $credits1;
        $log->coin = $credits4;
        $log->dealer = $data['Dealer'];
        $log->type = $data['Type'];
        $log->spent_at = $spent_at;
        $log->score_id = $data['SCORE_ID'];
        $log->generate_way = $data['generate_way'];
        $log->save();

        /*
        if($credits1 == 0 && $credits4 == 0){
            continue;
        }
        */
        $user_count = \App\UserCount::where('uid',$uid)->first();
        $user_count->extcredits1 += $credits1;
        $user_count->extcredits4 += $credits4;
        //更新积分
        DB::table('discuz_common_member_count')->where('uid',$uid)->update([
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
            'title'=>$data['title'],
            'text'=>\App\Helpers\Helper::replaceCarModel($data['Reason']),
        ]);
    }
    public function reference(Request $request)
    {
        $messages = [
            'frame_number.required' => '请填写17位数字加英文车架号',
            'frame_number.regex' => '请填写17位数字加英文车架号',
            'frame_number.unique' => '该车架号已经推荐过了',
            'username.required' => '必须填写推荐用户名',
            'username.exists' => '推荐的用户名不存在哦',
        ];
        $validator = Validator::make($request->all(), [
            'frame_number' => [
                'required',
                'unique:references,frame_number',
                'regex:/^[a-z0-9A-Z]{17}$/'
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
