<?php

namespace MPScholten\RequestParser;

class FloatParser extends AbstractValueParser
{
    protected function describe()
    {
        return "a floating point number";
    }

    protected function parse($value)
    {
        return is_numeric($value) ? (float)$value : null;
    }

    /**
     * @param float $defaultValue
     * @return float
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return float
     */
    public function required($invalidValueMessage = null, $notFoundMessage = null)
    {
        return parent::required($invalidValueMessage, $notFoundMessage);
    }

    /**
     * @param float $minValue
     * @param float $maxValue
     * @return FloatInRangeParser
     */
    public function inRange($minValue, $maxValue)
    {
        return new FloatInRangeParser($this->config, $this->name, $this->value, $minValue, $maxValue);
    }
}
