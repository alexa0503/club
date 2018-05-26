<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\DiscuzHelper;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use App\Verify;

class SendUserGroup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $verify;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Verify $verify)
    {
        $this->verify = $verify;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $log = new Logger('send_user_groups');
        $log->pushHandler(
            new StreamHandler(
                storage_path('logs/send_user_groups_'.date('Y-m-d').'.log'), 
                Logger::INFO
            )
        );
        $verify = $this->verify;
        $uid = $verify->uid;
        $frame_number = $verify->frame_number; //车架号
        DiscuzHelper::checkUserGroup($uid); //更新用户等级
        $user = \DB::table('discuz_common_member')
            ->join('discuz_common_usergroup', 'discuz_common_member.groupid', '=', 'discuz_common_usergroup.groupid')
            ->select('discuz_common_member.groupid', 'discuz_common_usergroup.grouptitle')
            ->where('uid', $uid)
            ->first();
        $groupid = $user == null ? 11 : $user->groupid;
        switch ($groupid) {
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
        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY03?wsdl", ['exceptions' => 0]);
        $options = [
            'json' => json_encode([
                'vin' => $frame_number,
                'member_level' => $member_level,
                'multiple' => $multiple,
                'total_scores' => $user_count->extcredits1,
                'total_fmb' => $user_count->extcredits4,
            ]),
        ];
        $response = $client->__soapCall("addMemberLevelInfo", array($options));

        if (!is_soap_fault($response)) {
            $log_info = '发送会员等级[' . $frame_number . ']:' . $response->addMemberLevelInfoReturn;
        } else {
            $log_info = '发送会员等级[' . $frame_number . ']:' . '失败.'."SOAP Fault: (faultcode: {$result->faultcode}, faultstring: {$result->faultstring})";
        }
        $log->addInfo($log_info);
    }
    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...
    }
}
