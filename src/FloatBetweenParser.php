<?php

namespace MPScholten\RequestParser;

class FloatBetweenParser extends AbstractBetweenParser
{
    protected function describe()
    {
        return "a float between $this->minValue and $this->maxValue";
    }

    /**
     * @param $value
     * @return float
     */
    protected function parse($value)
    {
        if (!is_numeric($value)) {
            return null;
        }
        $value = (float) $value;
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
