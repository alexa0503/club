<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    public function user()
    {
        if($this->thread()){
            $thread = $this->thread();
            return \App\User::where('uid', $thread->authorid)->first();
        }
        else{
            return '';
        }
        //$this->hasOne('App\UUser','username','username');
    }
    public function thread()
    {
        if(preg_match('/tid=(\d+)/i',$this->link, $matches)){
            $thread = \App\Thread::where('tid', $matches[1])->first();
            if($thread){
                return $thread;
            }
            else{
                return null;
            }
        }
        else{
            return null;
        }
    }
    public function getAvatarAttribute($value)
    {
        if( $this->thread() ){
            $thread = $this->thread();
            return url('/').'/bbs/uc_server/avatar.php?uid='.$thread->authorid.'&size=middle&_='.time();
        }
        else{

            return url('/').'/bbs/uc_server/avatar.php?uid=1&type=real&size=small';
        }
    }
    public function getLikeNumAttribute($value)
    {
        if($this->thread()){
            $thread = $this->thread();
            return $thread->views;
        }
        else{
            return 0;
        }
    }
    public function getShareNumAttribute($value)
    {
        if($this->thread()){
            $thread = $this->thread();
            return $thread->replies;
        }
        else{
            return 0;
        }
    }
    public function getUsernameAttribute($value)
    {
        if($this->thread()){
            $thread = $this->thread();
            return $thread->author;
        }
        else{
            return '超级风光';
        }
    }
}
