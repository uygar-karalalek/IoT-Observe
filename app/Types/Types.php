<?php

namespace App\Types;

const PHONE_TYPE = "Phone";
const ARDUINO_TYPE = "Arduino";
const PC_TYPE = "PC";

$light = new Type("light", "lux");
$accelerometer = new Type("accelerometer", "m/s^2");
$CO2 = new Type("CO2", "ppm");
$humidity = new Type("humidity", "g/m3");

define("SENSOR_TYPES", [
    PHONE_TYPE => [
        $light,
        $accelerometer
    ],
    ARDUINO_TYPE => [
        $light,
        $accelerometer,
        $CO2,
        $humidity
    ],
    PC_TYPE => [
        $light
    ]
]);

function getAllTypes(): array {
    $types = [];
    foreach (SENSOR_TYPES as $key => $value)
        $types[] = $key;
    return $types;
}
