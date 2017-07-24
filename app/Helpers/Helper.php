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
}
