<?php

namespace App\Services;

use App\Models\Flight;
use Illuminate\Support\Facades\DB;

class FlightConsultService
{
    private int $occupants;
    private string $departure_airport;
    private string $arrival_airport;
    private string $check_in;
    private string $check_out;
    private string $type;

    private function initConsult($search): void
    {
        $this->occupants = $search['occupants'];
        $this->departure_airport = $search['departure_airport'];
        $this->arrival_airport = $search['arrival_airport'];
        $this->check_in = $search['check_in'];
        $this->check_out = $search['check_out'];
        $this->type = $search['type'];
    }

    public function search_flight($search)
    {
        $this->initConsult($search);

        return $this->search_check_in();
    }


    private function search_check_in()
    {
        return Flight::select(
            [
                'code',
                'departure_airport_id',
                'arrival_airport_id',
                'departure_date',
                'arrival_date',
                'airplane_id',
                'duration',
                'base_price',
                'status',
                'airlines.name'
            ])
            ->join('airports AS airport_depart', 'flights.departure_airport_id', '=', 'airport_depart.id')
            ->join('airports AS airport_arrival', 'flights.arrival_airport_id', '=', 'airport_arrival.id')
            ->join('airlines', DB::raw('substr(flights.code,1,3)'), '=', 'airlines.slug')
            ->where('airport_depart.iata_code', '=', $this->departure_airport)
            ->where('airport_arrival.iata_code', '=', $this->arrival_airport)
            ->whereTime('departure_date', '>=', $this->check_in)
            ->get();
    }
}
