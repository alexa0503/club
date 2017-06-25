<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'discuz_ucenter_admins';
    public $timestamps = false;
    public function getAvatarAttribute($value)
    {
        return url('/').'/bbs/uc_server/avatar.php?uid='.$this->uid.'&type=real&size=small';
    }
}
