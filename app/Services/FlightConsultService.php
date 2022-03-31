<?php

namespace App\Services;

use App\Models\Distance;
use App\Models\Flight;
use Dflydev\DotAccessData\Data;
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
        $scale_check_in = $this->match_flights($this->departure_airport, $this->arrival_airport, $this->check_in);

        $check_outs = $this->search_flights($this->arrival_airport, $this->departure_airport, $this->check_out);
        $scale_check_out = $this->match_flights($this->arrival_airport, $this->departure_airport, $this->check_out);

        return array('Salida' =>
            [
                'departure_airport' => $this->departure_airport,
                'arrival_airport' => $this->arrival_airport,
                'check_in' => $this->check_in,
                'options' => $check_ins,
                'scales' => $scale_check_in
            ], 'Vuelta' => $check_outs, 'scales' => $scale_check_out);
    }


    private function search_flights($depart, $arrival, $date)
    {
        return Flight::select(
            [
                'flights.id',
                'airlines.name AS airline',
                'flights.code AS flight_number',
                'airport_depart.iata_code AS departure_airport',
                'airport_arrival.iata_code AS arrival_airport',
                'flights.departure_date',
                'flights.arrival_date',
                'flights.base_price as price',
            ])
            ->join('airports AS airport_depart', 'flights.departure_airport_id', '=', 'airport_depart.id')
            ->join('airports AS airport_arrival', 'flights.arrival_airport_id', '=', 'airport_arrival.id')
            ->join('airlines', DB::raw('substr(flights.code,1,3)'), '=', 'airlines.slug')
            ->join('airplanes', 'airlines.id', '=', 'airplanes.airline_id')
            ->where('airplanes.' . $this->type . '_class_seats', '>=', $this->occupants)
            ->where('airport_depart.iata_code', '=', $depart)
            ->where('airport_arrival.iata_code', '=', $arrival)
            ->where('flights.departure_date', '>=', $date)
            ->orderBy('flights.departure_date', 'ASC')
            ->limit(5)
            ->get();
    }

    private function search_scales($depart, $arrival, $date, $scale)
    {

        $condition_depart = $scale ? '<>' : '=';
        $condition_arrival = $scale ? '=' : '<>';


        return Flight::distinct()->select
        ([
            'flights.id',
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
            ->join('distances AS salida', 'salida.airport_1', '=', 'airport_depart.iata_code')
            ->join('distances AS llegada', 'llegada.airport_2', '=', 'airport_arrival.iata_code')
            ->join('airlines', DB::raw('substr(flights.code,1,3)'), '=', 'airlines.slug')
            ->join('airplanes', 'airlines.id', '=', 'airplanes.airline_id')
            ->where('airport_depart.iata_code', $condition_depart, $depart)
            ->where('airport_arrival.iata_code', $condition_arrival, $arrival)
            ->where('flights.departure_date', '>=', $date)
            ->orderBy('departure_date', 'ASC')
            ->limit(5)
            ->get();

    }

    public function match_flights($depart, $arrival, $date): array|string
    {
        $response = null;
        $first_flight = $this->search_scales($depart, $arrival, $date, false);
        $second_flight = $this->search_scales($depart, $arrival, $date, true);

        foreach ($first_flight as $flight) {
            for ($i = 0; $i < count($second_flight); $i++) {
                if ($second_flight[$i]['departure_date'] >= $flight['arrival_date'] && $flight['arrival_airport'] == $second_flight[$i]['departure_airport']) {
                    $response = array($flight, $second_flight[$i]);
                }
            }
        }
        return $response ?? 'The are not available scales for this flights.';
    }
}
