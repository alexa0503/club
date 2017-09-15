<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function indexItems()
    {
        return $this->hasMany('App\Item')->limit(6);
    }
}
