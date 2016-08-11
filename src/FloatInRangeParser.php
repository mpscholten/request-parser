<?php

namespace MPScholten\RequestParser;

class FloatInRangeParser extends AbstractInRangeParser
{
    protected function describe()
    {
        return "a float value between $this->minValue and $this->maxValue";
    }

    /**
     * @param $value
     * @return float
     */
    protected function parse($value)
    {
        return parent::parse($value);
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
     * @param string $invalidValueMessage
     * @param string $notFoundMessage
     * @return float
     */
    public function required($invalidValueMessage = null, $notFoundMessage = null)
    {
        return parent::required($invalidValueMessage, $notFoundMessage);
    }
}
