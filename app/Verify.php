<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verify extends Model
{
    public function getUserAttribute()
    {
        return \App\User::where('uid', $this->uid)->first();
    }
}
