<?php

namespace MPScholten\RequestParser;

class CommaSeparatedIntParser extends AbstractValueParser
{
    protected function parse($value)
    {
        if (empty($value)) {
            return null;
        }
        $value = explode(',', $value);
        return array_map('intval', $value);
    }

    /**
     * @param integer[] $defaultValue
     * @return integer[]
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return integer[]
     */
    public function required()
    {
        return parent::required();
    }
}
