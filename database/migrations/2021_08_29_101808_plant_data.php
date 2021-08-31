<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PlantData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('plant_data', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('temperature')->default('15˚ - 20˚');
            $table->string('daylight')->default('Yes');
            $table->string('water_duration')->default('7');
            $table->string('water_times')->default('1');
            $table->string('image')->default('default.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('plant_data');
        
    }
}
