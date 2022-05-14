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

    /**
     * @var DeviceSensorPropertiesEditForm[]
     */
    private array $props = [];

    /**
     * DeviceSensorEditForm constructor.
     * @param int $sensorId
     * @param string $type
     * @param string $device_uuid
     */
    public function __construct(int $sensorId, string $type, string $device_uuid)
    {
        $this->id = $sensorId;
        $this->type = $type;
        $this->device_uuid = $device_uuid;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return DeviceSensorPropertiesEditForm[]
     */
    public function getProps(): array
    {
        return $this->props;
    }

    /**
     * @param DeviceSensorPropertiesEditForm[] $props
     */
    public function setProps(array $props): void
    {
        $this->props = $props;
    }

    public static function fromSensorModel(Sensor $sensor): DeviceSensorEditForm {
        return new DeviceSensorEditForm($sensor->id, $sensor->type, $sensor->device_uuid);
    }

}
