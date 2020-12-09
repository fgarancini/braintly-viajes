<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->unsignedBigInteger('departure_airport_id');
            $table->dateTime('departure_date');
            $table->unsignedBigInteger('arrival_airport_id');
            $table->dateTime('arrival_date');
            $table->unsignedBigInteger('airplane_id');
            $table->unsignedInteger('duration');
            $table->decimal('base_price', 10, 2);
            $table->enum('status', ['scheduled', 'finished', 'flying', 'cancelled'])->default('scheduled');

            $table->foreign('departure_airport_id')->references('id')->on('airports');
            $table->foreign('arrival_airport_id')->references('id')->on('airports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flights');
    }
}
