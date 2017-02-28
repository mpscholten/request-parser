<?php

namespace MPScholten\RequestParser\Validator;

class IntLargerThanParser extends AbstractLargerThanParser
{
    protected function describe()
    {
        return "an integer larger than $this->minValue";
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
