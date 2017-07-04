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
}