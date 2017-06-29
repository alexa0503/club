<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function getUserAttribute()
    {
        return \App\User::where('uid', $this->uid)->first();
    }
    public function item()
    {
        return $this->belongsTo('App\Item');
    }
}
