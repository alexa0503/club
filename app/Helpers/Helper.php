<?php
namespace App\Helpers;
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
        $search = [
            'C31','C32','C35','C35(C31改)','C35(C32改)',
            'C36','C37','CK01','EC35','EC36',
            'EK05','EV25A','F503','F505','F506S',
            'F506','F507S','F507','K01','K01L',
            'K02','K02L','K05(K01)','K05(K01L)','K05(K02L)',
            'K05Ⅱ','K05N','K05S','K05','K07S',
            'K07Ⅱ','K07N','K07','K17','K21',
            'K22','K27','V07S','V21','V22',
            'V25','V25L','V26','V27','V29',
        ];
        $replace = [
            'C31','C32','C35','C35','C35',
            'C36','C37','','','',
            '','','','','风光360',
            '风光370','风光580','风光580智尚版','K01','K01',
            'K02','K02','K05','K05','K05',
            'K05','K05','K05','K05','K07',
            'K07','K07','K07','K17','K21',
            'K22','K27','V07','V21','V22',
            'V25','V25','V26','V27','V29',
        ];
        return str_ireplace($search, $replace, $string);
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
            'text'=> $reason,
        ]);
    }
}
