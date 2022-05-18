<?php


namespace App\FormCycle;

use Illuminate\Support\Facades\DB;

class DeviceSensorEditFormCycle
{

    /**
     * @var DeviceSensorEditForm|null
     */
    private ?DeviceSensorEditForm $addingSensor;

    /**
     * @var DeviceSensorEditForm[]
     */
    private array|DeviceSensorEditForm $sensors = [];

    /**
     * DeviceSensorEditFormCycle constructor.
     */
    public function __construct()
    {
        $this->addingSensor = null;
     }

    /**
     * @return DeviceSensorEditForm|null
     */
    public function getAddingSensor(): ?DeviceSensorEditForm
    {
        return $this->addingSensor;
    }

    /**
     * @param DeviceSensorEditForm|null $addingSensor
     */
    public function setAddingSensor(?DeviceSensorEditForm $addingSensor): void
    {
        $this->addingSensor = $addingSensor;
    }

    /**
     * @return DeviceSensorEditForm[]
     */
    public function getSensors(): array
    {
        return $this->sensors;
    }

    public function addSensor(DeviceSensorEditForm $sensorEditForm): void {
        $element = [$sensorEditForm->getId() => $sensorEditForm];
        $this->sensors = $element + $this->sensors;
    }

    /**
     * @param DeviceSensorEditForm[] $sensors
     */
    public function setSensors(array $sensors): void
    {
        $this->sensors = $sensors;
    }

    public function isAddingSensor(): bool {
        return $this->addingSensor != null;
    }

    public function removeSensorByIdFromDb(mixed $sensorId)
    {
        $soils = $this->getSensors()[$sensorId]->getProps()->getProperties();
        foreach ($soils as $value) {
            DB::table("sensor_soil")->where("id", "=", $value->getId())->delete();
        }
        DB::table("sensor")->where("id", "=", $sensorId)->delete();
    }

    public function deleteSensor(mixed $sensorId)
    {
        unset($this->sensors[$sensorId]);
    }

}
