<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function getRouteKeyName()
    {
        return 'alias_name';
    }
    public function blocks()
    {
        return $this->hasMany('App\Block')->where('is_posted', 1)->orderBy('sort_id', 'ASC');
    }
}
