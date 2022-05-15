<?php


namespace App\FormCycle;


use App\Models\SensorSoil;
use App\Utils\DbUtils;
use Illuminate\Support\Facades\DB;
use stdClass;

class DeviceSensorProperty
{

    private int $id;
    private int $sensorId;
    private float $soilValue;
    private string $operator;
    private string $aggregation_logic;

    /**
     * DeviceSensorProperty constructor.
     * @param float $soilValue
     * @param string $operator
     * @param string $aggregation_logic
     */
    public function __construct(int $sensorId, $soilId = -1,
                                float $soilValue = 0.0,
                                string $operator = ">",
                                string $aggregation_logic = "and")
    {
        $this->sensorId = $sensorId;
        $this->id = $soilId > 0 ? $soilId : (1 + DbUtils::getMaxId("sensor_soil"));
        $this->soilValue = $soilValue;
        $this->operator = $operator;
        $this->aggregation_logic = $aggregation_logic;
    }

    /**
     * @return int|mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getSoilValue(): float
    {
        return $this->soilValue;
    }

    /**
     * @param float $soilValue
     */
    public function setSoilValue(float $soilValue): void
    {
        $this->soilValue = $soilValue;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * @param string $operator
     */
    public function setOperator(string $operator): void
    {
        $this->operator = $operator;
    }

    /**
     * @return string
     */
    public function getAggregationLogic(): string
    {
        return $this->aggregation_logic;
    }

    /**
     * @param string $aggregation_logic
     */
    public function setAggregationLogic(string $aggregation_logic): void
    {
        $this->aggregation_logic = $aggregation_logic;
    }

    /**
     * @return int
     */
    public function getSensorId(): int
    {
        return $this->sensorId;
    }

    public static function fromSoilModel(stdClass $sensorSoil): DeviceSensorProperty
    {

        return new DeviceSensorProperty(
            $sensorSoil->sensor_id,
            $sensorSoil->id,
            $sensorSoil->soil_value,
            $sensorSoil->operator,
            $sensorSoil->aggregation_logic
        );
    }

    public function copyFrom(DeviceSensorProperty $deviceSensorProperty) {
        $this->setAggregationLogic($deviceSensorProperty->getAggregationLogic());
        $this->setOperator($deviceSensorProperty->getOperator());
        $this->setSoilValue($deviceSensorProperty->getSoilValue());
    }

    public function persist(bool $update = false)
    {
        if ($update) {
            DB::table("sensor_soil")->where("id", "=", $this->getId())
                ->update(['operator' => $this->getOperator(),
                        "soil_value" => $this->getSoilValue(),
                        "aggregation_logic" => $this->getAggregationLogic()]
                );
        } else {
            $sensorProp = new SensorSoil();
            $sensorProp->id = $this->getId();
            $sensorProp->operator = $this->getOperator();
            $sensorProp->soil_value = $this->getSoilValue();
            $sensorProp->aggregation_logic = $this->getAggregationLogic();
            $sensorProp->sensor_id = $this->getSensorId();

            $sensorProp->save();
        }
    }

}
