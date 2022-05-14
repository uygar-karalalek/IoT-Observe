<?php


namespace App\FormCycle;


use App\Models\Sensor;

class DeviceSensorEditForm
{

    /**
     * @var int
     */
    private int $id;

    private string $type;

    private string $device_uuid;

    private bool $toSave;

    /**
     * @var DeviceSensorPropertiesEditForm
     */
    private DeviceSensorPropertiesEditForm $props;

    /**
     * DeviceSensorEditForm constructor.
     * @param int $sensorId
     * @param string $type
     * @param string $device_uuid
     * @param bool $toSave
     */
    public function __construct(int $sensorId, string $type, string $device_uuid, bool $toSave = false)
    {
        $this->id = $sensorId;
        $this->type = $type;
        $this->device_uuid = $device_uuid;
        $this->props = new DeviceSensorPropertiesEditForm();
        $this->toSave = $toSave;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getDeviceUuid(): string
    {
        return $this->device_uuid;
    }

    /**
     * @return bool
     */
    public function isToSave(): bool
    {
        return $this->toSave;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return DeviceSensorPropertiesEditForm
     */
    public function getProps(): DeviceSensorPropertiesEditForm
    {
        return $this->props;
    }

    /**
     * @param DeviceSensorPropertiesEditForm $props
     */
    public function setProps(DeviceSensorPropertiesEditForm $props): void
    {
        $this->props = $props;
    }

    public static function fromSensorModel(Sensor $sensor, bool $toSave): DeviceSensorEditForm {
        return new DeviceSensorEditForm($sensor->id, $sensor->type, $sensor->device_uuid, $toSave);
    }

}
