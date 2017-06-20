<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $casts = [
        'gallery' => 'array'
    ];
}
