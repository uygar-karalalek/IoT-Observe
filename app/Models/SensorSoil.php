<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorSoil extends Model
{
    use HasFactory;

    protected $table = "sensor_soil";

    protected $fillable = [
        "id",
        "operator_soil",
        "soil_value",
        "aggregation_logic",
        "sensor_id"
    ];

}
