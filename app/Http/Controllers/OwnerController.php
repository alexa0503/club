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
            'frame_number.*' => '请填写17位数字加英文车架号',
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
                $credits1 = 4000;
                $credits4 = 0;
                break;
            case 'F370':
                $credits1 = 2000;
                $credits4 = 0;
                break;
            case 'F330':
                $credits1 = 1000;
                $credits4 = 0;
                break;
            default:
                $credits1 = 1000;
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
        $verifies = \App\Verify::where('uid',$uid)->get();
        foreach($verifies as $verify){
            $frame_number = $verify->frame_number;//车架号
            $id_card = $verify->id_card;//身份证号
            $options = [
                'frame_number'=>$frame_number,
                'id_card'=>$id_card,
                'Start_date'=>'2000-01-01',
                'End_date'=>date('Y-m-d'),
            ];

            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY02SOAP?wsdl");
            $options = [
                'in'=>json_encode($options),
            ];
            $response = $client->__soapCall("queryPartsInfo", array($options));
            $result = json_decode($response->out,true);

            $first_upkeep = true;
            $user = \App\User::where('uid',$uid)->first();
            if($result && $result['ret'] == 0){
                foreach ($result['data'] as $data){
                    $spent_at = date('Y-m-d H:i:s',strtotime($data['spent_at']));
                    $count = \App\OwnerLog::where('dealer', $data['Dealer'])
                        ->where('uid', $uid)
                        ->where('spent_at', $spent_at)
                        ->count();

                    $point = $data['Point'];
                    $coin = $data['Coin'];

                    if( $data['Type'] == 1){
                        switch ($user->groupid){
                            case 12:
                                $credits1 = $point*1.2;
                                $credits4 = $coin*1.2;
                                break;
                            case 13:
                                $credits1 = $point*1.5;
                                $credits4 = $coin*1.5;
                                break;
                            case 14:
                                $credits1 = $point*2;
                                $credits4 = $coin*2;
                                break;
                            default:
                                $credits1 = $point;
                                $credits4 = $coin;
                        }
                    }
                    else{
                        switch ($user->groupid){
                            case 12:
                                $credits1 = 150;
                                $credits4 = 150;
                                break;
                            case 13:
                                $credits1 = 200;
                                $credits4 = 200;
                                break;
                            case 14:
                                $credits1 = 300;
                                $credits4 = 300;
                                break;
                            default:
                                $credits1 = 100;
                                $credits4 = 100;
                        }

                        //第一次保养
                        if( $first_upkeep == true ){
                            $credits1 = 0;
                            $credits4 = 0;
                            $first_upkeep = false;
                        }
                    }

                    if( $count > 0 ){
                        continue;
                    }

                    $log = new \App\OwnerLog();
                    $log->verify_id = $verify->id;
                    $log->uid = $uid;
                    $log->reason = $data['Reason'];
                    $log->point = $credits1;
                    $log->coin = $credits4;
                    $log->dealer = $data['Dealer'];
                    $log->type = $data['Type'];
                    $log->spent_at = $spent_at;
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
                        'title'=>'车主购买奖励',
                        'text'=>$data['Reason'],
                    ]);
                }
            }
        }
        return [];
    }
}
