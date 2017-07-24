<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CarsRefund extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cars:refund';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $verifies = \App\Verify::where('status','>=', 0)->get();
        foreach($verifies as $verify){
            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY06SOAP?wsdl");
            $options = [
                'in'=>json_encode([
                    'frame_number'=>$verify->frame_number,
                ])
            ];
            $response = $client->__soapCall("QueryVehicleReturnInfo", array($options));
            $result = json_decode($response->out,true);
            //var_dump($verify->frame_number,$result);
            if( $result && $result['ret'] == 0 && $result['return_type'] == 2){
                $verify->status = -1;
                $verify->save();
                $uid = $verify->uid;

                $user_count = \App\UserCount::where('uid',$uid)->first();

                switch (strtoupper($verify->model_code)){
                    case 'F507':
                    case 'F507S':
                        $credits1 = -4000;
                        $credits4 = 0;
                        break;
                    case 'F506':
                    case 'F506S':
                        $credits1 = -2000;
                        $credits4 = 0;
                        break;
                    default:
                        $credits1 = -500;
                        $credits4 = 0;
                }
                $user_count->extcredits1 += $credits1;
                $user_count->extcredits4 += $credits4;
                //更新积分
                \DB::table('discuz_common_member_count')
                    ->where('uid',$uid)
                    ->update([
                        'extcredits1' => $user_count->extcredits1,
                        'extcredits4' => $user_count->extcredits4,
                    ]);
                $logid = \DB::table('discuz_common_credit_log')->insertGetId([
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
                \DB::table('discuz_common_credit_log_field')->insert([
                    'logid'=>$logid,
                    'title'=>'车主退车',
                    'text'=>'车主退车扣除奖励',
                ]);
            }
        }
    }
}
