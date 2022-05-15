<?php


namespace App\FormCycle;


class DeviceSensorPropertiesEditForm
{

    /**
     * @var DeviceSensorProperty[]|array
     */
    private array $properties = [];

    public function add(DeviceSensorProperty $deviceSensorProperty) {
        $this->properties[$deviceSensorProperty->getId()] = $deviceSensorProperty;
    }

    public function remove($id) {
        unset($this->properties[$id]);
    }

     /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

}
