<?php


namespace App\Types;


class Type
{

    /**
     * @var string
     */
    private $key;
    /**
     * @var string
     */
    private $unit;

    /**
     * Type constructor.
     * @param $key
     * @param $unit
     */
    public function __construct($key, $unit)
    {
        $this->key = $key;
        $this->unit = $unit;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

}
