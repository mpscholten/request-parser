<?php

namespace MPScholten\RequestParser;

class YesNoBooleanParser extends AbstractValueParser
{
    protected function describe()
    {
        return "either yes or no";
    }

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
    public function required($invalidValueMessage = null, $notFoundMessage = null)
    {
        return parent::required($invalidValueMessage, $notFoundMessage);
    }
}
