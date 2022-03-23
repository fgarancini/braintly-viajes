<?php

namespace App\Services;

use App\Models\Airport;

class AirportService
{
    protected Airport $airport;

    public function __construct(Airport $airport)
    {
        $this->airport = $airport;
    }
    
    public function search_airport($iata_code)
    {
        return $this->airport->where('iata_code', $iata_code)->firstOrFail()->id;
    }
}
