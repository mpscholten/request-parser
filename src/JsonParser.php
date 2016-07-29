<?php

namespace MPScholten\RequestParser;

class JsonParser extends AbstractValueParser
{
    protected function describe()
    {
        return "a json encoded value";
    }

    protected function parse($value)
    {
        return json_decode($value, true);
    }

    /**
     * @param array $defaultValue
     * @return array
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    public function required()
    {
        return parent::required();
    }
}
