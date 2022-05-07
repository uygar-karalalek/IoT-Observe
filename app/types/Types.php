<?php

use App\types\Type;

$light = new Type("light", "lux");
$accelerometer = new Type("accelerometer", "m/s^2");
$CO2 = new Type("CO2", "ppm");
$humidity = new Type("humidity", "g/m3");

define("SENSOR_TYPES", [
    "Phone" => [
        $light,
        $accelerometer
    ],
    "Arduino" => [
        $light,
        $accelerometer,
        $CO2,
        $humidity
    ],
    "PC" => [
        $light
    ]
]);
