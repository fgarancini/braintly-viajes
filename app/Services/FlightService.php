<?php

namespace App\Services;

use App\Models\Flight;

class FlightService
{
    protected Flight $flight;

    public function __construct(Flight $flight)
    {
        $this->flight = $flight;
    }


    public function search_departed($check_in): object
    {
        return $this->flight->whereDate('departure_date', $check_in)->get();
    }


}
