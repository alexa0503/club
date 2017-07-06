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
        $frame_number = 'LVZA53P94GC578465';//车架号
        $id_card = '450305197012070019';//身份证号
        $options = [
            'frame_number'=>$frame_number,
            'id_card'=>$id_card,
            'Start_date'=>date('Y-m-d', strtotime('-1000 days')),
            'End_date'=>date('Y-m-d', strtotime('+1 days')),
        ];
        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY02SOAP?wsdl");
        $options = [
            'in'=>json_encode($options),
        ];
        var_dump($client->__getTypes());
        $response = $client->__soapCall("queryPartsInfo", array($options));
        $result = json_decode($response->out,true);
        var_dump($result);
        return;
        $member_verify = DB::table('discuz_common_member_verify')->where('verify1',1)->get();
        foreach($member_verify as $row){
            $profile = DB::table('discuz_common_member_profile')->where('uid',$row->uid)->get();
            if( null == $profile) {
                continue;
            }
            $frame_number = $profile->field1;//车架号
            $id_card = $profile->field3;//身份证号
            $options = [
                'frame_number'=>$frame_number,
                'id_card'=>$id_card,
            ];
            $client = new \SoapClient("http://interface.dfsk.com.cn/infodms_interface_hy/services/HY02SOAP?wsdl");
            $options = [
                'in'=>json_encode($options),
            ];
            $response = $client->__soapCall("Hy02", array($options));
            $result = json_decode($response->out,true);
            $credits1 = 0;
            $credits4 = 0;
            if($result && $result['ret'] == 0){
                foreach ($result['data'] as $data){
                    $spent_at = date('Y-m-d H:i:s',strtotime($data['spent_at']));
                    $count = \App\PointLog::where('dealer', $data['Dealer'])
                        ->where('uid', $row->uid)
                        ->where('spent_at', $spent_at)
                        ->count();
                    if( $count > 0){
                        continue;
                    }
                    $point_log = new \App\PointLog();
                    $point_log->uid = $row->uid;
                    $point_log->reason = $data['Reason'];
                    $point_log->point = $data['Point'];
                    $point_log->coin = $data['Coin'];
                    $point_log->dealer = $data['Dealer'];
                    $point_log->type = $data['Type'];
                    $point_log->spent_at = $spent_at;
                    $point_log->save();
                    $credits1 += $data['Point'];
                    $credits4 += $data['Coin'];
                }
                $user = \App\User::where('uid',$row->uid)->first();
                if($user->groupid == 12){
                    $credits1 = $credits1*1.2;
                }
                elseif($user->groupid == 13){
                    $credits1 = $credits1*1.5;
                }
                elseif($user->groupid == 14){
                    $credits1 = $credits1*2;
                }
                $user_count = \App\UserCount::where('uid',$row->uid)->first();
                $user_count->extcredits1 += $credits1;
                $user_count->extcredits4 += $credits4;
                //更新积分
                DB::table('discuz_common_member_count')->where('uid',$row->uid)->update([
                    'extcredits1' => $user_count->extcredits1,
                    'extcredits4' => $user_count->extcredits4,
                ]);
                //$user_count->save();
                $logid = DB::table('discuz_common_credit_log')->insertGetId([
                    'uid' => $row->uid,
                    'operation'=>'',
                    'relatedid'=>$row->uid,
                    'dateline'=>time()+8*3600,
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
                    'text'=>'车主购买奖励',
                ]);
                $this->info($row->uid);
            }
        }
    }
}
