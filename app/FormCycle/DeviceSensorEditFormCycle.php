<?php


namespace App\FormCycle;


class DeviceSensorEditFormCycle
{

    /**
     * @var bool
     */
    private $editingActive;

    /**
     * @var DeviceSensorEditForm[]
     */
    private $sensors;

    /**
     * DeviceSensorEditFormCycle constructor.
     * @param bool $editingIsActive
     * @param DeviceSensorEditForm $editingFields
     */
    public function __construct(bool $editingIsActive, DeviceSensorEditForm $editingFields)
    {
        $this->editingActive = $editingIsActive;
        $this->sensors = $editingFields;
    }

    /**
     * @return bool
     */
    public function isEditingActive(): bool
    {
        return $this->editingActive;
    }

    /**
     * @param bool $editingActive
     */
    public function setEditingActive(bool $editingActive): void
    {
        $this->editingActive = $editingActive;
    }

    /**
     * @return DeviceSensorEditForm
     */
    public function getSensors(): DeviceSensorEditForm
    {
        return $this->sensors;
    }

    /**
     * @param DeviceSensorEditForm $sensors
     */
    public function setSensors(DeviceSensorEditForm $sensors): void
    {
        $this->sensors = $sensors;
    }

}
