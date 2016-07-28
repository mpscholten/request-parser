<?php

namespace MPScholten\RequestParser;

class CommaSeparatedStringParser extends AbstractValueParser
{
    protected function describe()
    {
        return "a comma separated list of text";
    }

    protected function parse($value)
    {
        return explode(',', $value);
    }

    /**
     * @param string[] $defaultValue
     * @return string[]
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return string[]
     */
    public function required()
    {
        return parent::required();
    }
}
