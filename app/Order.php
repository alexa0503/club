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

}
