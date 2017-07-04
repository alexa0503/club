<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    protected $fillable = [
        'uid',
        'area',
        'name',
        'detail',
        'mobile',
        'telephone',
        'email',
        'alias'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'uid', 'uid');
    }
}
