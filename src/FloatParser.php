<?php

namespace Common\Foundation\RequestSpec;

namespace MPScholten\RequestParser;

class FloatParser extends AbstractValueParser
{
    protected function parse($value)
    {
        return is_numeric($value) ? (float)$value : null;
    }

    /**
     * @param float $defaultValue
     * @return float
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return float
     */
    public function required()
    {
        return parent::required();
    }
}
