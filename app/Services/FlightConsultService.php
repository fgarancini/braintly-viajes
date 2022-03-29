<?php

namespace App\Services;

use App\Models\Distance;
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
        $this->type = $search['type'] == 'economic' ? 'economy' : 'first';
    }

    public function search_flight($search)
    {
        $this->initConsult($search);

        $check_ins = $this->search_flights($this->departure_airport, $this->arrival_airport, $this->check_in);
        $check_outs = $this->search_flights($this->arrival_airport, $this->departure_airport, $this->check_out);

        return array('Salida' =>
            [
                'departure_airport' => $this->departure_airport,
                'arrival_airport' => $this->arrival_airport,
                'check_in' => $this->check_in,
                'options' => $check_ins
            ], 'Vuelta' => $check_outs);
    }


    private function search_flights($depart, $arrival, $date)
    {
        return Flight::select(
            [
                'airlines.name AS airline',
                'code AS flight_number',
                'airport_depart.iata_code AS departure_airport',
                'airport_arrival.iata_code AS arrival_airport',
                'departure_date',
                'arrival_date',
                'base_price as price',
            ])
            ->join('airports AS airport_depart', 'flights.departure_airport_id', '=', 'airport_depart.id')
            ->join('airports AS airport_arrival', 'flights.arrival_airport_id', '=', 'airport_arrival.id')
            ->join('airlines', DB::raw('substr(flights.code,1,3)'), '=', 'airlines.slug')
            ->join('airplanes', 'airlines.id', '=', 'airplanes.airline_id')
            ->where('airplanes.' . $this->type . '_class_seats', '>=', $this->occupants)
            ->where('airport_depart.iata_code', '=', $depart)
            ->where('airport_arrival.iata_code', '=', $arrival)
            ->whereTime('departure_date', '>=', $date)
            ->orderBy('departure_date', 'ASC')
            ->limit(5)
            ->get();
    }

    private function search_scales()
    {
        return Flight::distinct()->select
        ([
            'airlines.name AS airline',
            'code AS flight_number',
            'airport_depart.iata_code AS departure_airport',
            'airport_arrival.iata_code AS arrival_airport',
            'departure_date',
            'arrival_date',
            'base_price as price',
        ])
            ->join('airports AS airport_depart', 'flights.departure_airport_id', '=', 'airport_depart.id')
            ->join('airports AS airport_arrival', 'flights.arrival_airport_id', '=', 'airport_arrival.id')
            ->join('airlines', DB::raw('substr(flights.code,1,3)'), '=', 'airlines.slug')
            ->join('distances AS salida', 'salida.airport_1', '=', 'airport_depart.iata_code')
            ->join('distances AS llegada', 'llegada.airport_2', '=', 'airport_arrival.iata_code')
            ->join('airplanes', 'airlines.id', '=', 'airplanes.airline_id')
            ->where('airport_depart.iata_code', '=', $this->departure_airport)
            ->where('airport_arrival.iata_code', '<>', $this->arrival_airport)
            ->where('flights.departure_date', '>=', '2022-03-29')
            ->where('flights.departure_date', '<=', date_add(date_create('2022-03-29'), date_interval_create_from_date_string('5 days')))
            ->orderBy('departure_date', 'ASC')
            ->limit(5)
            ->get();

//            ->whereBetween('flights.departure_date', ['2022-03-29', DB::raw('DATE_ADD(2022-03-29,INTERVAL 5 DAY)')])
    }

}
