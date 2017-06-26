<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OwnerVerify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'owner:verify';

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
        $member_verify = DB::table('discuz_common_member_verify')->where('verify1',0)->get();
        foreach($member_verify as $row){
            if($row->verify1 == 0){
                $info = DB::table('discuz_common_member_verify_info')->where('verifytype',1)->where('uid', $row->uid)->first();
                if( $info->flag == 0 ){
                    $data = @unserialize($info->field);
                    if( !$data || !isset($data['field1']) || !$data['field3']){
                        continue;
                    }

                    $frame_number = $data['field1'];//车架号
                    $id_card = $data['field3'];//身份证号
                    //$car_model = $string['field4'];//汽车型号
                    //$frame_number = 'LVZMN2595EA575190';
                    //$id_card = '612112198706081063';
                    //LVZMN2595EA575190 612112198706081063
                    $options = [
                        'frame_number'=>$frame_number,
                        'id_card'=>$id_card,
                        'register_date'=>date('Y-m-d H:i:s'),
                        'type'=>'1',
                    ];
                    $client = new \SoapClient("http://interface.dfsk.com.cn/infodms_interface_hy/services/HY01SOAP?wsdl");
                    $options = [
                        'in'=>json_encode($options),
                    ];
                    $response = $client->__soapCall("Hy01", array($options));
                    $result = json_decode($response->out,true);
                    if($result['ret'] == 0){

                        $user_count = new \App\UserCount;
                        $credits1 = 300;
                        $credits4 = 300;
                        /*
                        if($car_model == '风光580'){

                        }
                        */

                        $user_count->extcredits1 += $credits1;
                        $user_count->extcredits4 += $credits4;
                        //更新积分
                        $logid = DB::table('discuz_common_credit_log')->insertGetId([
                            'uid' => $row->uid,
                            'operation'=>'',
                            'relatedid'=>0,
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
                            'title'=>'车主认证',
                            'text'=>'车主认证通过奖励',
                        ]);
                        //更新数据到用户信息
                        foreach ($data as $k=>$v){
                            if(empty($v)){
                                unset($data);
                            }
                        }
                        DB::table('discuz_common_member_profile')
                            ->where('uid', $row->uid)
                            ->update($data);
                        //更新验证状态
                        DB::table('discuz_common_member_verify')->where('verify1', 0)
                            ->where('uid', $row->uid)
                            ->update(['verify1' => 1]);
                        //删除验证信息
                        DB::table('discuz_common_member_verify_info')->where('verifytype',1)->where('uid', $row->uid)->delete();
                    }
                    else{
                        DB::table('discuz_common_member_verify')
                            ->where('verify1', 0)
                            ->where('uid', $row->uid)
                            ->update(['verify1' => -1]);
                        DB::table('discuz_common_member_verify_info')
                            ->where('verifytype',1)
                            ->where('uid', $row->uid)
                            ->update(['flag'=>-1]);
                    }
                }
            }

        }
        /*

        */
        return $result;
    }
}
