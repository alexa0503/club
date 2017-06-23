<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCount extends Model
{
    protected $table = 'discuz_common_member_count';
    public $timestamps = false;
    public function getPointAttribute($value)
    {
        return $this->extcredits4;
    }
}
