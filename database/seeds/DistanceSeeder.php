<?php

use App\Models\Airport;
use App\Models\Distance;
use App\Models\Flight;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistanceSeeder extends Seeder
{
    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Distance::query()->truncate();
        $airports = Airport::all();
        foreach($airports as $airport1) {
            foreach($airports as $airport2) {
                if($airport1->id === $airport2->id) continue;

                Distance::create([
                    'airport_1' => $airport1->iata_code,
                    'airport_2' => $airport2->iata_code,
                    'kilometers' => $this->distance($airport1->lat, $airport1->lon, $airport2->lat, $airport2->lon, 'K'),
                ]);
            }
        }
    }
}
