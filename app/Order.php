<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $casts = [
        'items'=>'array'
    ];
    public function getUserAttribute()
    {
        return \App\User::where('uid', $this->uid)->first();
    }
    public function getNumberAttribute()
    {
        return date('YmdHi', strtotime($this->created_at)).$this->id;
    }
    public function _items()
    {
        return $this->belongsToMany('App\Item', 'order_items', 'order_id', 'item_id');
    }

}
