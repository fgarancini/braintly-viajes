<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAirportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('iata_code');
            $table->string('location');
            $table->string('country');
            $table->float('lat');
            $table->float('lon');
        });

        DB::table('airports')->insert([
            ['country' => 'Argentina', 'location' => 'Ezeiza', 'name' => 'Aeropuerto Internacional Ministro Pistarini', 'iata_code' => 'EZE', 'lat' => -34.849758, 'lon' => -58.516460],
            ['country' => 'Argentina', 'location' => 'Mar del plata', 'name' => 'Aeropuerto Internacional Astor Piazzolla', 'iata_code' => 'MDQ', 'lat' => -37.934, 'lon' => -57.573],
            ['country' => 'Argentina', 'location' => 'Bariloche', 'name' => 'Aeropuerto Internacional Teniente Luis Candelaria', 'iata_code' => 'BRC', 'lat' => -41.151, 'lon' => -71.157],
            ['country' => 'Chile', 'location' => 'Santiago de Chile', 'name' => 'Aeropuerto Internacional Comodoro Arturo Merino Benitez', 'iata_code' => 'SCL', 'lat' => -33.393, 'lon' => -70.786],
            ['country' => 'Mexico', 'location' => 'Ciudad de Mexico', 'name' => 'Aeropuerto Internacional Benito Juarez', 'iata_code' => 'MEX', 'lat' => 19.436, 'lon' => -99.072],
            ['country' => 'Colombia', 'location' => 'Bogotá', 'name' => 'Aeropuerto Internacional El Dorado', 'iata_code' => 'BOG', 'lat' => 4.701, 'lon' => -74.147],
            ['country' => 'Perú', 'location' => 'Bogotá', 'name' => 'Aeropuerto Internacional Jorge Chávez', 'iata_code' => 'LIM', 'lat' => -12.022, 'lon' => -77.114],
            ['country' => 'Bolivia', 'location' => 'Santa Cruz', 'name' => 'Aeropuerto Internacional Viru Viru', 'iata_code' => 'VVI', 'lat' => -17.645, 'lon' => -63.135],
            ['country' => 'Venezuela', 'location' => 'Caracas', 'name' => 'Aeropuerto Internacional de Miaquetía Simón Bolivar', 'iata_code' => 'CCS', 'lat' => 10.603, 'lon' => -66.991],
            ['country' => 'Brasil', 'location' => 'Sao Paulo', 'name' => 'Aeropuerto Internacional de Sao Paulo-Guarulhos', 'iata_code' => 'GRU', 'lat' => -23.432, 'lon' => -46.469],
            ['country' => 'Canada', 'location' => 'Ottawa', 'name' => 'Aeropuerto Internacional de Ottawa', 'iata_code' => 'YOW', 'lat' => 45.323, 'lon' => -75.669],
            ['country' => 'Estados Unidos', 'location' => 'Miami', 'name' => 'Aeropuerto Internacional de Miami', 'iata_code' => 'MIA', 'lat' => 25.793, 'lon' => -80.291],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('airports');
    }
}
