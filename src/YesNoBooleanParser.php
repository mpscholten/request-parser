<?php

namespace MPScholten\RequestParser;

class YesNoBooleanParser extends AbstractValueParser
{
    protected function parse($value)
    {
        if (!isset($value)) {
            return null;
        }
        return strtoupper($value) === 'YES' || strtoupper($value) === 'Y';
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
