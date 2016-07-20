<?php

namespace MPScholten\RequestParser;

class CommaSeparatedStringParser extends AbstractValueParser
{
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
