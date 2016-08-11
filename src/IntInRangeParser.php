<?php

namespace MPScholten\RequestParser;

class IntInRangeParser extends AbstractInRangeParser
{
    protected function describe()
    {
        return "an integer value between $this->minValue and $this->maxValue";
    }

    /**
     * @param $value
     * @return int
     */
    protected function parse($value)
    {
        return parent::parse($value);
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
     * @param string $invalidValueMessage
     * @param string $notFoundMessage
     * @return int
     */
    public function required($invalidValueMessage = null, $notFoundMessage = null)
    {
        return parent::required($invalidValueMessage, $notFoundMessage);
    }
}