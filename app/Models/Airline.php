<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    public function airplanes()
    {
        return $this->hasMany('App\\Models\\Airplane');
    }

}
