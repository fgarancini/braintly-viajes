<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    public function depart()
    {
        return $this->hasMany(Flight::class, 'departure_airport_id');
    }

    public function arrival()
    {
        return $this->hasMany(Flight::class, 'arrival_airport_id');
    }

}
