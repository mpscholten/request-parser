<?php

namespace MPScholten\RequestParser\Validator;

class StringLengthLargerThanOrEqualToParser extends AbstractLargerThanOrEqualToParser
{
    protected function describe()
    {
        return "a string longer than or equal to $this->minValue characters";
    }

    /**
     * @param $value
     * @return int
     */
    protected function parse($value)
    {
        if (strlen($value) >= $this->minValue) {
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