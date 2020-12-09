<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAirlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airlines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->string('primary_color');
            $table->string('secondary_color');
        });

        DB::table('airlines')->insert([
            ['name' => 'Tiger Travels', 'slug' => 'TTR', 'primary_color' => '#508AA8', 'secondary_color' => '#D8E4FF'],
            ['name' => 'Phalcon Airlines', 'slug' => 'PAS', 'primary_color' => '#35605A', 'secondary_color' => '#00120B'],
            ['name' => 'Lion Air', 'slug' =>'LNA', 'primary_color' => '#4C6663', 'secondary_color' => '#A31621']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('airlines');
    }
}
