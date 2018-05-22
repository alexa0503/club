<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function indexItems()
    {
        return $this->hasMany('App\Item')->orderBy('feature2', 'ASC')->limit(6);
    }
}
