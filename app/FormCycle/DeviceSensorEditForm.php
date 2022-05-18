<?php


namespace App\FormCycle;


use App\Models\Sensor;
use JetBrains\PhpStorm\Pure;

class DeviceSensorEditForm
{

    /**
     * @var int
     */
    private int $id;

    private string $type;

    private string $device_uuid;

    private bool $editing = false;

    /**
     * @var DeviceSensorPropertiesEditForm
     */
    private DeviceSensorPropertiesEditForm $props;

    /**
     * DeviceSensorEditForm constructor.
     * @param int $sensorId
     * @param string $type
     * @param string $device_uuid
     */
    #[Pure] public function __construct(int $sensorId, string $type, string $device_uuid)
    {
        $this->id = $sensorId;
        $this->type = $type;
        $this->device_uuid = $device_uuid;
        $this->props = new DeviceSensorPropertiesEditForm();
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
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
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


    public function removeProperty($propId)
    {
        $this->getProps()->remove($propId);
    }

    public static function fromSensorModel(Sensor $sensor): DeviceSensorEditForm
    {
        return new DeviceSensorEditForm($sensor->id, $sensor->type, $sensor->device_uuid);
    }

    /**
     * @return bool
     */
    public function isEditing(): bool
    {
        return $this->editing;
    }

    /**
     * @param bool $editing
     */
    public function setEditing(bool $editing): void
    {
        $this->editing = $editing;
    }

}
