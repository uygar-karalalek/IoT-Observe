<?php

namespace App\Types;

class Types
{

    public static $PHONE_TYPE = "Phone";
    public static $ARDUINO_TYPE = "Arduino";
    public static $PC_TYPE = "PC";

    public static $light;
    public static $accelerometer;
    public static $CO2;
    public static $humidity;
    /**
     * @return array
     */
    public static function SENSORS(): array
    {
        static $types = [];
        self::init();

        if (count($types) == 0) {


            $types[self::$PHONE_TYPE] = [
                self::$light,
                self::$accelerometer
            ];
            $types[self::$ARDUINO_TYPE] = [
                self::$light,
                self::$accelerometer,
                self::$CO2,
                self::$humidity
            ];
            $types[self::$PC_TYPE] = [
                self::$light
            ];
        }
        return $types;
    }

    static function DEVICE_TYPES(): array
    {
        self::init();

        $types = [];
        $SENSOR_TYPES = self::SENSORS();
        foreach ($SENSOR_TYPES as $key => $value)
            $types[] = $key;
        return $types;
    }

    static function SENSOR_TYPES(): array
    {
        self::init();

        return [
            self::$light,
            self::$accelerometer,
            self::$CO2,
            self::$humidity
        ];
    }

    private static function init(): void
    {
        self::$light = self::$light == null ? new Type("light", "lux") : self::$light;
        self::$accelerometer = self::$accelerometer == null ? new Type("accelerometer", "m/s^2") : self::$accelerometer;
        self::$CO2 = self::$CO2 == null ? new Type("CO2", "ppm") : self::$CO2;
        self::$humidity = self::$humidity == null ? new Type("humidity", "g/m3") : self::$humidity;
    }

}
