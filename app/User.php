<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'discuz_common_member';
    public $timestamps = false;
    public function addresses()
    {
        $this->hasMany('App\DeliverAddress','uid','uid');
    }
    public function userCount()
    {
        return \App\UserCount::where('uid', $this->uid)->first();
    }

    public function getUserCountAttribute()
    {
        return $this->userCount();
    }
    public function userGroup()
    {
        return \App\UserGroup::where('groupid', $this->groupid)->first();
    }
    public function getUserGroupAttribute()
    {
        return $this->userGroup();
    }

    public function getAvatarAttribute($value)
    {
        return url('/').'/bbs/uc_server/avatar.php?uid='.$this->uid.'&size=middle&_='.time();
    }

}
