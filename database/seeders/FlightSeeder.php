<?php
namespace Database\Seeders;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Distance;
use App\Models\Flight;
use Carbon\Carbon;
use Illuminate\Database\Seeder;


class FlightSeeder extends Seeder
{
    public function generateStatus($start, $end) {
        if(now()->between($start, $end))
            return 'flying';
        elseif (now() < $start)
            return 'scheduled';
        elseif (now() > $end)
            return 'finished';
    }

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Flight::query()->truncate();

        $day = Carbon::today();
        $airlines = Airline::all();
        $counter = 0;
        $airports = Airport::all();
        for(; $day < Carbon::today()->addDays(90); $day->addDay()) {
            foreach($airlines as $airline) {
                for($x = 0; $x < 4; $x++) {
                    $departureAirport = $airports->random();
                    $arrivalAirport = $airports->random();
                    while($departureAirport->id === $arrivalAirport->id)
                        $arrivalAirport = $airports->random();

                    $airplanes = $airline->airplanes;
                    $randomHour = random_int(0, 23);
                    $counter++;
                    $distance = Distance::where('airport_1', $departureAirport->iata_code)->where('airport_2', $arrivalAirport->iata_code)->firstOrFail();
                    $duration = round($distance->kilometers / 800, 2);
                    $departureDate = Carbon::create($day->year, $day->month, $day->day, $randomHour, 0, 0);
                    $arrivalDate = clone $departureDate;
                    $arrivalDate->addHours($duration);
                    Flight::create([
                        'code' => "$airline->slug-$counter",
                        'departure_airport_id' => $departureAirport->id,
                        'departure_date' => $departureDate,
                        'arrival_airport_id' => $airports->random()->id,
                        'arrival_date' => $arrivalDate,
                        'airplane_id' => $airplanes->random()->id,
                        'duration' => $duration,
                        'base_price' => round($distance->kilometers / 10.2,2),
                        'status' => $this->generateStatus($departureDate, $arrivalDate)
                    ]);
                }
            }
        }
    }
}
