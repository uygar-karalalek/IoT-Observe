<?php


namespace App\Types;


class Type implements \JsonSerializable
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

    public function jsonSerialize(): array
    {
        $data = [];
        $data["key"] = $this->key;
        $data["unit"] = $this->unit;
        return $data;
    }
}
