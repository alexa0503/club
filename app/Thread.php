<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $table = 'discuz_forum_thread';
    public $timestamps = false;
}
