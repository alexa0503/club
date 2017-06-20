<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'uid', 'uid');
    }
}
