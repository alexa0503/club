<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'discuz_common_member';
    public function addresses()
    {
        $this->hasMany('App\DeliverAddress','uid','uid');
    }
}
