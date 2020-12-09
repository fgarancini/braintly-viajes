<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{
    protected $fillable = [
        'airport_1',
        'airport_2',
        'kilometers'
    ];

    public $timestamps = false;
}
