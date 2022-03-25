<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    public $timestamps = false;

//    protected fillable = ['departure_airport_id', 'departure_date', 'arrival_airport_id', 'arrival_date'];

    public function airport()
    {
        return $this->belongsTo(Airport::class, 'departure_airport_id');
    }
}
