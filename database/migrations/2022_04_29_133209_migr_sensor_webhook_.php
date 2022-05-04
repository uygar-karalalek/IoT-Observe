<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_webhook', function (Blueprint $table) {
            $table->id();
            $table->string('curl');
            $table->bigInteger("sensor_id")->nullable(false)->unsigned();
            $table->foreign("sensor_id")->references("id")->on("sensor");
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
