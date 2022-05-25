<?php


namespace App\Models\Builder;


use App\Models\Sensor;
use App\Types\Types;

class SensorBuilder
{

    private int $id;
    private string $deviceUuid;
    private $type;

    public function build(): Sensor     {
        if ($this->type == null)
            $this->type = Types::SENSOR_TYPES()[1]->getKey();

        $newSensor = new Sensor();
        $newSensor->id = $this->id;
        $newSensor->type = $this->type;
        $newSensor->device_uuid = $this->deviceUuid;
        return $newSensor;
    }

    public function withId(int $id): SensorBuilder {
        $this->id = $id;
        return $this;
    }

    public function withDeviceUuid(string $deviceUuid): SensorBuilder {
        $this->deviceUuid = $deviceUuid;
        return $this;
    }

    public function withType($type) {
        $this->type = $type;
        return $this;
    }

}

