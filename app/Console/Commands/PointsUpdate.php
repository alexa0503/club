<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Helpers\DiscuzHelper;

class PointsUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'points:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update owner\'s points';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $verifies = \App\Verify::where('status','>=',0)->get();
        foreach($verifies as $verify){
            $uid = $verify->uid;
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
            DiscuzHelper::checkUserGroup($verify->uid);//更新用户等级
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
            \Log::info('积分新增['.$frame_number.']:'.$response->out);
            //var_dump($result);
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
                    \App\Helpers\Helper::updateLog($uid,$data);
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
            \Log::info('工单取消['.$frame_number.']:'.$response->out);
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
                    /*
                    \App\OwnerLog::where('uid', $uid)
                        ->where('generate_way', 2)
                        ->where('rono', $data['Rono'])
                        ->delete();
                    */
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
    }
}
