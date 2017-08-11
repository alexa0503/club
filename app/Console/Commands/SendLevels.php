<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Helpers\DiscuzHelper;

class SendLevels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:levels';

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
        $verifies = \App\Verify::where('status','>=',0)->get();
        foreach($verifies as $verify){
            DiscuzHelper::checkUserGroup($verify->uid);//更新用户等级
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
            $frame_number = $verify->frame_number;//车架号
            $user_count = \DB::table('discuz_common_member_count')->where('uid', $uid)->first();
            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY03?wsdl");
            $options = [
                'json'=>json_encode([
                    'vin'=>$frame_number,
                    'member_level'=>$member_level,
                    'multiple'=>$multiple,
                    'total_scores'=>$user_count->extcredits1,
                    'total_fmb'=>$user_count->extcredits4,
                ])
            ];
            $response = $client->__soapCall("addMemberLevelInfo", array($options));
            //$result = json_decode($response->addMemberLevelInfoReturn,true);
            \Log::info('发送会员等级['.$frame_number.']:'.$response->addMemberLevelInfoReturn);
        }
    }
}