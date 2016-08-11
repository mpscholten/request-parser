<?php

namespace MPScholten\RequestParser;

class IntParser extends AbstractValueParser
{
    protected function describe()
    {
        return "an integer";
    }

    protected function parse($value)
    {
        return is_numeric($value) ? (int)$value : null;
    }

    /**
     * @param int $defaultValue
     * @return int
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return int
     */
    public function required($invalidValueMessage = null, $notFoundMessage = null)
    {
        return parent::required($invalidValueMessage, $notFoundMessage);
    }

    /**
     * @param int $minvalue
     * @param int $maxValue
     * @return IntInRangeParser
     */
    public function inRange($minvalue, $maxValue)
    {
        return new IntInRangeParser($this->config, $this->name, $this->value, $minvalue, $maxValue);
    }
}
