<?php


namespace App\FormCycle;


class DeviceSensorProperty
{

    private float $soilValue;
    private string $operator;
    private string $aggregation_logic;

    /**
     * DeviceSensorProperty constructor.
     * @param float $soilValue
     * @param string $operator
     * @param string $aggregation_logic
     */
    public function __construct(float $soilValue, string $operator, string $aggregation_logic)
    {
        $this->soilValue = $soilValue;
        $this->operator = $operator;
        $this->aggregation_logic = $aggregation_logic;
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


}
