<?php

namespace MPScholten\RequestParser;

class YesNoBooleanParser extends AbstractValueParser
{
    protected function parse($value)
    {
        if (strtoupper($value) === 'YES' || strtoupper($value) === 'Y') {
            return true;
        }
        if (strtoupper($value) === 'NO' || strtoupper($value) === 'N') {
            return false;
        }

        return null;
    }

    protected function describe()
    {
        return "either YES or NO";
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
