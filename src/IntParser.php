<?php

namespace MPScholten\RequestParser;

class IntParser extends AbstractValueParser
{
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
    public function required()
    {
        return parent::required();
    }

    /**
     * @throws \Exception
     * @param int $minValue
     * @param int $maxValue
     * @return int
     */
    public function inRange($minValue, $maxValue)
    {
        $value = $this->parse($this->value);
        if (is_null($value) || $value < $minValue || $value > $maxValue) {
            throw new \Exception("Out of range");
        }
        return $this->value;
    }
}
