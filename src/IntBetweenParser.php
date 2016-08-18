<?php

namespace MPScholten\RequestParser;

class IntBetweenParser extends AbstractBetweenParser
{
    protected function describe()
    {
        return "an integer between $this->minValue and $this->maxValue";
    }

    /**
     * @param $value
     * @return int
     */
    protected function parse($value)
    {
        if (!is_numeric($value)) {
            return null;
        }
        $value = (int) $value;
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
