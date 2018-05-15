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
            case '370N':
                $return = '风光360/370';
                break;
            case 'F507':
            case 'F507S':
                $return = '风光580';
                break;
            case 'F516':
                $return = '风光S560';
                break;
            case 'F503S':
                $return = '风光330S';
                break;
            default:
                $return = '小康微车';
                break;
        }

        return $return;
    }
    public static function getCreditsFromCarModel($model_code)
    {
        //$_code = self::replaceCarModel($model_code);
        switch ($model_code){
            case '风光580':
            case '风光580智尚版':
                $credits1 = 4000;
                $credits4 = 0;
                break;
            case '风光S560':
                $credits1 = 3000;
                $credits4 = 0;
                break;
            case '风光370':
            case '风光360':
            case '风光360/370':
                $credits1 = 2000;
                $credits4 = 0;
                break;
            case '风光330':
            case '风光330S':
                $credits1 = 1000;
                $credits4 = 0;
                break;
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
        $reason = $data['Reason'];
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
        if( isset($data['recommended_model_code']) ){
            $log->recommended_model_code = \App\Helpers\Helper::replaceCarModel($data['recommended_model_code']);
        }
        if( isset($data['recommended_frame_number']) ){
            $log->recommended_frame_number = $data['recommended_frame_number'];
        }
        $log->save();

        /*
        if($credits1 == 0 && $credits4 == 0){
            continue;
        }
        */
        $user_count = \App\UserCount::where('uid',$uid)->first();
        if( $user_count != null ){
            $user_count->extcredits1 += $credits1;
            $user_count->extcredits4 += $credits4;
            //更新积分
            \DB::table('discuz_common_member_count')->where('uid',$uid)->update([
                'extcredits1' => $user_count->extcredits1,
                'extcredits4' => $user_count->extcredits4,
            ]);
        }

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
    ///积分更新
    public static function pointsUpdate($verify)
    {
        $uid = $verify->uid;
        $frame_number = $verify->frame_number;//车架号

        $_log = \App\OwnerLog::where('verify_id', $verify->id)->where('generate_way',1)->orderBy('score_id','DESC')->first();
        if( $_log == null ){
            $score_id = 0;
        }
        else{
            $score_id = $_log->score_id;
        }
        //新增积分
        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY02SOAP?wsdl",['exceptions' => 0]);
        $options = [
            'in'=>json_encode([
                'frame_number'=>$frame_number,
                'score_id' => $score_id,
            ])
        ];
        $response = $client->__soapCall("queryPartsInfo", array($options));
        if( !is_soap_fault($response)){
            $result = json_decode($response->out,true);
        }
        else{
            $result = null;
        }


        if($result && $result['ret'] == 0 && isset($result['data']) && is_array($result['data'])){
            foreach ($result['data'] as $data){
                $count = \App\OwnerLog::where('score_id',$data['SCORE_ID'])->withTrashed()->count();
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
        $_log = \App\OwnerLog::where('verify_id', $verify->id)->where('generate_way',2)->orderBy('score_id','DESC')->first();
        if( $_log == null ){
            $score_id = 0;
        }
        else{
            $score_id = $_log->score_id;
        }
        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY05SOAP?wsdl",['exceptions' => 0]);
        $options = [
            'in'=>json_encode([
                'frame_number'=>$frame_number,
                'score_id' => $score_id,
            ])
        ];
        $response = $client->__soapCall("CancelOrderAccount", array($options));
        if( !is_soap_fault($response)){
            $result1 = json_decode($response->out,true);
        }
        else{
            $result1 = null;
        }


        //var_dump($result1);
        if($result1 && $result1['ret'] == 0 && isset($result1['data']) && is_array($result1['data'])){
            foreach ($result1['data'] as $data){
                $count = \App\OwnerLog::where('score_id',$data['SCORE_ID'])->withTrashed()->count();
                if( $count > 0 ){
                    continue;
                }
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

    public static function object_array($array) {  
        if(is_object($array)) {  
            $array = (array)$array;  
        } if(is_array($array)) {  
            foreach($array as $key=>$value) {  
                $array[$key] = \App\Helpers\Helper::object_array($value);  
            }  
        }  
        return $array;  
    }  

    public static function mk_dir($dir, $mode = 0777) {
        if (is_dir($dir) || @mkdir($dir, $mode))
            return true;
        if (!\App\Helpers\Helper::mk_dir(dirname($dir), $mode))
            return false;
        return @mkdir($dir, $mode);
    }
}
