<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;
    protected $casts = [
        'inventories' => 'array',
        'images' => 'array',
    ];
    protected $dates = ['deleted_at'];
    public function inventoriesToString()
    {
        $string = '';
        foreach($this->inventories as $inventory){
            $string .= $inventory['color'].':'.$inventory['quantity']."\t";
        }
        return $string;
    }
    public function getThumbAttribute($value)
    {
        if( $this->images && count($this->images) > 0 ){
            return $this->images[0];
        }
        else{
            return '';
        }
    }
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }
    public function dealer()
    {
        return $this->belongsTo('App\Dealer');
    }
}
