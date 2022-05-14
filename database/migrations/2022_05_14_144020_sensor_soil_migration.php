<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_soil', function (Blueprint $table) {
            $table->id();
            $table->string("operator");
            $table->double("soil_value");
            $table->string("aggregation_logic");
            $table->bigInteger("sensor_id")->nullable(false)->unsigned();
            $table->foreign("sensor_id")->references("id")->on("sensor");
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
