<?php

namespace MPScholten\RequestParser;

class BooleanParser extends AbstractValueParser
{
    protected function parse($value)
    {
        if (!isset($value)) {
            return null;
        }
        return strtoupper($value) === 'TRUE' || strtoupper($value) === '1';
    }

    /**
     * @param boolean $defaultValue
     * @return boolean
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return boolean
     */
    public function required()
    {
        return parent::required();
    }
}
