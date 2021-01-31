<?php

namespace MPScholten\RequestParser;

class OnOffBooleanParser extends AbstractValueParser
{
    protected function describe()
    {
        return "either on or off";
    }

    protected function parse($value)
    {
        if (strtoupper($value) === 'ON') {
            return true;
        }
        if (strtoupper($value) === 'OFF') {
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
