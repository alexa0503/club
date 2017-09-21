<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function item()
    {
        return $this->belongsTo('App\Item','item_id','id');
    }
    public function order()
    {
        return $this->belongsTo('App\Order','order_id','id');
    }
}
