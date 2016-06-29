<?php

namespace MPScholten\RequestParser;

class BooleanParser extends AbstractValueParser
{
    protected function parse($value)
    {
        if (strtoupper($value) === 'TRUE' || $value === '1') {
            return true;
        }
        if (strtoupper($value) === 'FALSE' || $value === '0') {
            return false;
        }
        return null;
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
