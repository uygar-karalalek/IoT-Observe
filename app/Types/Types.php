<?php

namespace App\Types;

class Types
{

    public static string $PHONE_TYPE = 'Phone';
    public static string $ARDUINO_TYPE = 'Arduino';
    public static string $PC_TYPE = 'PC';

    public static ?Type $light = null;
    public static ?Type $accelerometer = null;
    public static ?Type $CO2 = null;
    public static ?Type $humidity = null;

    /**
     * @return array
     */
    public static function DEVICE_TYPES_AND_SENSORS(): array
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
        $SENSOR_TYPES = self::DEVICE_TYPES_AND_SENSORS();
        foreach ($SENSOR_TYPES as $key => $value)
            $types[] = $key;
        return $types;
    }

    static function SENSOR_KEY_AND_TYPES(): array {
        self::init();

        return [
            self::$light->getKey() => self::$light,
            self::$accelerometer->getKey() => self::$accelerometer,
            self::$CO2->getKey() => self::$CO2,
            self::$humidity->getKey() => self::$humidity
        ];
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

    private static bool $initialized = false;

    private static function init(): void
    {
        if (!self::$initialized) {
            self::$light = self::$light == null ? new Type("light", "lux") : self::$light;
            self::$accelerometer = self::$accelerometer == null ? new Type("accelerometer", "m/s2") : self::$accelerometer;
            self::$CO2 = self::$CO2 == null ? new Type("CO2", "ppm") : self::$CO2;
            self::$humidity = self::$humidity == null ? new Type("humidity", "g/m3") : self::$humidity;

            self::$initialized = true;
        }
    }

}
