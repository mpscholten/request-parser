<?php

namespace MPScholten\RequestParser\Validator;

class StringLengthSmallerThanOrEqualToParser extends AbstractSmallerThanOrEqualToParser
{
    protected function describe()
    {
        return "a string shorter than or equal to $this->maxValue characters";
    }

    /**
     * @param $value
     * @return int
     */
    protected function parse($value)
    {
        if (strlen($value) <= $this->maxValue) {
            return $value;
        }
        return null;
    }

    /**
     * @param string $defaultValue
     * @return string
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @param string $invalidValueMessage
     * @param string $notFoundMessage
     * @return string
     */
    public function required($invalidValueMessage = null, $notFoundMessage = null)
    {
        return parent::required($invalidValueMessage, $notFoundMessage);
    }
}