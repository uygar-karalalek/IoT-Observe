<?php


namespace App\FormCycle;


use Illuminate\Support\Facades\DB;

class DeviceSensorEditFormCycle
{

    /**
     * @var DeviceSensorEditForm|null
     */
    private ?DeviceSensorEditForm $editingSensor;

    /**
     * @var DeviceSensorEditForm[]
     */
    private array|DeviceSensorEditForm $sensors = [];

    /**
     * DeviceSensorEditFormCycle constructor.
     */
    public function __construct()
    {
        $this->editingSensor = null;
     }

    /**
     * @return DeviceSensorEditForm
     */
    public function getEditingSensor(): DeviceSensorEditForm
    {
        return $this->editingSensor;
    }

    /**
     * @param DeviceSensorEditForm $editingSensor
     */
    public function setEditingSensor(DeviceSensorEditForm $editingSensor): void
    {
        $this->editingSensor = $editingSensor;
    }

    /**
     * @return DeviceSensorEditForm[]
     */
    public function getSensors(): array
    {
        return $this->sensors;
    }

    public function addSensor(DeviceSensorEditForm $sensorEditForm): void {
        $this->sensors[] = $sensorEditForm;
    }

    /**
     * @param DeviceSensorEditForm $sensors
     */
    public function setSensors(DeviceSensorEditForm $sensors): void
    {
        $this->sensors = $sensors;
    }

    public function isEditingActive(): bool {
        return $this->editingSensor != null;
    }

    public function saveEditingSensor() {
    }

}
