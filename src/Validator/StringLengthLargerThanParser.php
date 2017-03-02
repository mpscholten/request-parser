<?php

namespace MPScholten\RequestParser\Validator;

class StringLengthLargerThanParser extends AbstractLargerThanParser
{
    protected function describe()
    {
        return "a string longer than $this->minValue characters";
    }

    /**
     * @param $value
     * @return int
     */
    protected function parse($value)
    {
        if (!is_string($value)) {
            return null;
        }
        $value = strlen($value);
        return parent::parse($value);
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