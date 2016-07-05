<?php

namespace MPScholten\RequestParser;

class CommaSeparatedStringParser extends AbstractValueParser
{
    protected function parse($value)
    {
        return explode(",", $value);
    }

    /**
     * @param array $defaultValue
     * @return array
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return array
     */
    public function required()
    {
        return parent::required();
    }
}
