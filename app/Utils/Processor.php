<?php


namespace App\Utils;


use App\Models\Sensor;
use App\Models\SensorSoil;
use Closure;

class Processor
{

    private string $sensorType;

    /**
     * Processor constructor.
     * @param $sensorType
     */
    public function __construct($sensorType)
    {
        $this->sensorType = $sensorType;
    }

    public function process(float $value): bool
    {
        $all = Sensor::query()->where("type", "=", $this->sensorType)->get()->all();
        foreach ($all as $sensorRelated) {
            $ands = SensorSoil::query()->where("sensor_id", "=", $sensorRelated->id)
                ->where("aggregation_logic", "=", "and")->get()->all();
            $ors = SensorSoil::query()->where("sensor_id", "=", $sensorRelated->id)->where("aggregation_logic", "=", "or")->get()->all();

            $makeControl = function (float $value, float $soilValue, string $operator): bool {
                if ($operator == ">")
                    return $value > $soilValue;

                else if ($operator == "<")
                    return $value < $soilValue;

                else if ($operator == '<=')
                    return $value <= $soilValue;

                else if ($operator == '>=')
                    return $value >= $soilValue;

                return false;
            };

            $andsResult = count($ands) > 0;
            foreach ($ands as $andSoil) $andsResult = $andsResult && $this->getResult($andSoil, $makeControl, $value);
            $orsResult = false;
            foreach ($ors as $orSoil) $orsResult = $orsResult || $this->getResult($orSoil, $makeControl, $value);

            if ($andsResult || $orsResult) return true;
        }
        return false;
    }


    /**
     * @param mixed $soil
     * @param Closure $makeControl
     * @param float $value
     * @return bool
     */
    private function getResult(mixed $soil, Closure $makeControl, float $value): bool
    {
        $operator = $soil->operator;
        $soilVal = $soil->soil_value;
        return  $makeControl($value, $soilVal, $operator);
    }

}
