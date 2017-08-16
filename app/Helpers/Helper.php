<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;
/**
 *
 */
class Helper
{
    public static function getInventory($inventories,$color)
    {
        $inventory = [
            'quantity' => 0,
        ];
        foreach($inventories as $v){
            if($v['color'] == $color){
                $inventory = $v;
                break;
            }
        }
        return $inventory['quantity'];
    }
    public static function replaceCarModel($string)
    {
        $string = strtoupper($string);
        switch ($string) {
            case 'F503':
            case 'F505':
                $return = '风光330';
                break;
            case 'F506':
            case 'F506S':
                $return = '风光360/370';
                break;
            case 'F507':
            case 'F507S':
                $return = '风光580';
                break;
            default:
                $return = '小康微车';
                break;
        }

        return $return;
    }
    public static function getCreditsFromCarModel($model_code)
    {
        $_code = self::replaceCarModel($model_code);
        switch ($_code){
            case '风光580':
            case '风光580智尚版':
                $credits1 = 4000;
                $credits4 = 0;
                break;
            case '风光370':
            case '风光360':
            case '风光360/370':
                $credits1 = 2000;
                $credits4 = 0;
                break;
            case '风光330':
                $credits1 = 1000;
                $credits4 = 0;
                break;
            default:
                $credits1 = 500;
                $credits4 = 0;
        }
        return $credits1;
    }
    public static function updateLog($uid,$data)
    {
        if( $data['generate_way'] == 2 ){
            $credits1 = (-1)*abs($data['Point']);
            $credits4 = (-1)*abs($data['Coin']);
        }
        else{
            $credits1 = $data['Point'];
            $credits4 = $data['Coin'];
        }
        $reason = self::replaceCarModel($data['Reason']);
        //\App\Helpers\Helper::replaceCarModel($data['Reason']);
        $spent_at = date('Y-m-d H:i:s',strtotime($data['spent_at']));
        $log = new \App\OwnerLog();
        $log->verify_id = $data['verify_id'];
        $log->uid = $uid;
        $log->reason = $reason;
        $log->point = $credits1;
        $log->coin = $credits4;
        $log->dealer = $data['Dealer'];
        $log->type = $data['Type'];
        $log->rono = $data['Rono'];
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
        \DB::table('discuz_common_member_count')->where('uid',$uid)->update([
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
            'title'=>$data['title'],
            'text'=> $reason,
        ]);
    }
    //生成优惠券码
    public static function generateCouponCode()
    {
        $bytes = random_bytes(6);
        $code = date('Ymd').substr(bin2hex($bytes), 0, 6);
        $count = \App\Coupon::where('code', $code)->count();
        if($count > 0){
            return \App\Helpers\Helper::generateCouponCode();
        }
        else{
            return $code;
        }
    }
}
