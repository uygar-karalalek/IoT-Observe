<?php


namespace App\Repository;


use App\Models\Device;
use App\Models\Sensor;
use App\Models\SensorSoil;
use App\Utils\DbUtils;
use Illuminate\Support\Facades\DB;

class SensorRepository
{

    public function getNextSensorId(): int {
        $max = DbUtils::getMaxId("sensor");
        return 1 + ($max ?? 0);
    }

    public function removeWhereDeviceUuid(mixed $deviceUuid) {
        $sensors = DB::table("sensor")->where("device_uuid", "=", $deviceUuid)->get()->all();
        foreach ($sensors as $sensor) {
            $sid = $sensor->id;
            DB::table("sensor_soil")->where("sensor_id", "=", $sid)->delete();
        }
        DB::table("sensor")->where("device_uuid", "=", $deviceUuid)->delete();
        DB::table("device")->where("uuid", "=", $deviceUuid)->delete();
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
