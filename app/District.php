<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false;
    public function children()
    {
        return $this->hasMany('App\District', 'parent_id', 'id')->orderBy('order_id', 'ASC');
    }
    public function parent()
    {
        return $this->belongsTo('App\District', 'parent_id', 'id');
    }
}
