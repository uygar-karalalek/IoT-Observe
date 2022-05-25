<?php


namespace App\Repository;


use App\Utils\DbUtils;
use Illuminate\Support\Facades\DB;

class SensorRepository
{

    public function getNextSensorId(): int {
        $max = DbUtils::getMaxId("sensor");
        return 1 + ($max ?? 0);
    }

    public function getSensorsWhereDeviceUuidEquals(string $deviceUuid): array
    {
        $collection = DB::table("sensor")->where("device_uuid", "=", $deviceUuid)->get();
        $mappedSensors = [];
        foreach ($collection as $value) {
            $sensor = new Sensor();
            $sensor->id = $value->id;
            $sensor->type = $value->type;
            $sensor->device_uuid = $value->device_uuid;
            $sensor->created_at = $value->created_at;
            $sensor->updated_at = $value->updated_at;
            $mappedSensors[] = $sensor;
        }
        return $mappedSensors;
    }

}
