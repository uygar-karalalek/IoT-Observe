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

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

}
