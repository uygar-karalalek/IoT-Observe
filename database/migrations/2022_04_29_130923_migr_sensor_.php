<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    const SENSOR_TYPES = ["Photoresistor", "Humidity", "CO2"];

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('sensor', function (Blueprint $table) {
            $table->id();
            $table->enum('type', self::SENSOR_TYPES);
            $table->string('device_uuid');
            $table->foreign('device_uuid')->references('uuid')->on('device');
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
    }
};
