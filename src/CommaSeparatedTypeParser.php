<?php

namespace MPScholten\RequestParser;

class CommaSeparatedTypeParser
{
    private $value;
    private $name;
    private $exceptionFactory;

    const INT = 'INT';
    const STRING = 'STRING';
    const FLOAT = 'FLOAT';
    const BOOLEAN = 'BOOLEAN';
    const YES_NO_BOOLEAN = 'YES_NO_BOOLEAN';
    const JSON = 'JSON';
    const DATE_TIME = 'DATE_TIME';

    public function __construct(callable $exceptionFactory, $name, $value)
    {
        $this->exceptionFactory = $exceptionFactory;
        $this->value = $value;
        $this->name = $name;
    }

    /**
     * @return int[]
     */
    public function int()
    {
        $valuesArr = [];
        foreach (explode(',', $this->value) as $value) {
           $valuesArr[] = (new IntParser($this->exceptionFactory, $this->name, $value))->required();
        }
        return $valuesArr;
    }

    /**
     * @return float[]
     */
    public function float()
    {
        $valuesArr = [];
        foreach (explode(',', $this->value) as $value) {
            $valuesArr[] = (new FloatParser($this->exceptionFactory, $this->name, $value))->required();
        }
        return $valuesArr;
    }

    /**
     * @return string[]
     */
    public function string()
    {
        $valuesArr = [];
        foreach (explode(',', $this->value) as $value) {
            $valuesArr[] = (new StringParser($this->exceptionFactory, $this->name, $value))->required();
        }
        return $valuesArr;
    }

    /**
     * @return \DateTime[]
     */
    public function dateTime()
    {
        $valuesArr = [];
        foreach (explode(',', $this->value) as $value) {
            $valuesArr[] = (new DateTimeParser($this->exceptionFactory, $this->name, $value))->required();
        }
        return $valuesArr;
    }

    /**
     * @return array
     */
    public function json()
    {
        $valuesArr = [];
        if (!empty($this->value) && $this->value[0] !== '[' && $this->value[strlen($this->value) - 1] !== ']') {
            $this->value = '[' . $this->value . ']';
        }
        $this->value = json_decode($this->value, true);
        foreach (explode(',', $this->value) as $value) {
            $valuesArr[] = (new JsonParser($this->exceptionFactory, $this->name, json_encode($value)))->required();
        }
        return $valuesArr;
    }

    /**
     * @return boolean[]
     */
    public function yesNoBoolean()
    {
        $valuesArr = [];
        foreach (explode(',', $this->value) as $value) {
            $valuesArr[] = (new YesNoBooleanParser($this->exceptionFactory, $this->name, $value))->required();
        }
        return $valuesArr;
    }

    /**
     * @return boolean[]
     */
    public function boolean()
    {
        $valuesArr = [];
        foreach (explode(',', $this->value) as $value) {
            $valuesArr[] = (new BooleanParser($this->exceptionFactory, $this->name, $value))->required();
        }
        return $valuesArr;
    }
}
