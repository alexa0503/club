<?php
namespace App\Helpers;
/**
 *
 */
class DiscuzHelper
{
    //protected static $key = '85be29aDkjYOAQgU';
    public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    	$ckey_length = 4;
    	$key = md5($key != '' ? $key : self::getglobal('authkey'));
    	$keya = md5(substr($key, 0, 16));
    	$keyb = md5(substr($key, 16, 16));
    	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

    	$cryptkey = $keya.md5($keya.$keyc);
    	$key_length = strlen($cryptkey);

    	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    	$string_length = strlen($string);

    	$result = '';
    	$box = range(0, 255);

    	$rndkey = array();
    	for($i = 0; $i <= 255; $i++) {
    		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
    	}

    	for($j = $i = 0; $i < 256; $i++) {
    		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
    		$tmp = $box[$i];
    		$box[$i] = $box[$j];
    		$box[$j] = $tmp;
    	}

    	for($a = $j = $i = 0; $i < $string_length; $i++) {
    		$a = ($a + 1) % 256;
    		$j = ($j + $box[$a]) % 256;
    		$tmp = $box[$a];
    		$box[$a] = $box[$j];
    		$box[$j] = $tmp;
    		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    	}

    	if($operation == 'DECODE') {
    		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
    			return substr($result, 26);
    		} else {
    			return '';
    		}
    	} else {
    		return $keyc.str_replace('=', '', base64_encode($result));
    	}
    }
    public static function getglobal($key, $group = null) {
    	global $_G;
    	$key = explode('/', $group === null ? $key : $group.'/'.$key);
    	$v = &$_G;
    	foreach ($key as $k) {
    		if (!isset($v[$k])) {
    			return null;
    		}
    		$v = &$v[$k];
    	}
    	return $v;
    }
    public static function formatTime($timestamp, $format = null)
    {
        //$timestamp += 8*3600;
        $now = time();
        $diff_time = $now - $timestamp;
        if($diff_time < 60){
            return $diff_time.'秒前';
        }
        elseif($diff_time < 60*60){
            return floor($diff_time/60).'分前';
        }
        elseif($diff_time < 60*60*24){
            $min = floor(($diff_time - floor($diff_time/3600)*3600)/60);
            return floor($diff_time/3600).'时'.$min.'分前';
        }
        elseif($diff_time < 30*60*60*24){
            $day = floor($diff_time/(60*60*24));
            $hour = floor(($diff_time-$day*60*60*24)/3600);
            $min = floor(($diff_time - floor($diff_time/3600)*3600)/60);
            return $day.'天'.$hour.'时'.$min.'分前';
        }
        else{
            if( $format ){
                return date($format,$timestamp);
            }
            return date('y/m/d H:i:s',$timestamp);
        }
    }
    //检查积分，用户组是否正确
    public static function checkUserGroup($id)
    {
        $user_group = \DB::table('discuz_common_member')
            ->join('discuz_common_usergroup','discuz_common_member.groupid','=','discuz_common_usergroup.groupid')
            ->select('discuz_common_member.groupid')
            ->where('uid',$id)->first();
        $user_count = \DB::table('discuz_common_member_count')->where('uid',$id)->first();

        $right_group = \DB::table('discuz_common_usergroup')
            ->where('type','member')
            ->where('creditslower', '>', $user_count->extcredits1)
            ->where('creditshigher', '<=', $user_count->extcredits1)
            ->select('groupid')
            ->first();

        if($user_group->groupid != $right_group->groupid){
            \DB::table('discuz_common_member')->where('uid',$id)->update([
                'groupid'=>$right_group->groupid
            ]);
        }

    }

}
