<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    public function user()
    {
        if($this->username){
            return \App\UUser::where('username', $this->username)->first();
        }
        else{
            return '';
        }
        //$this->hasOne('App\UUser','username','username');
    }
    public function getAvatarAttribute($value)
    {
        if( $this->user() ){
            $user = $this->user();
            return url('/').'/bbs/uc_server/avatar.php?uid='.$user
                ->uid.'&type=real&size=small';
        }
        else{
            return '';
        }
    }
    public function getLikeNumAttribute($value)
    {
        return rand(1,2000);
    }
    public function getShareNumAttribute($value)
    {
        return rand(1,2000);
    }
}
