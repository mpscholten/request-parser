<?php

namespace MPScholten\RequestParser;

class CommaSeparatedFloatParser extends AbstractValueParser
{
    protected function parse($value)
    {
        if (empty($value)) {
            return null;
        }
        $value = explode(',', $value);
        return array_map('floatval', $value);
    }

    /**
     * @param float[] $defaultValue
     * @return float[]
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return float[]
     */
    public function required()
    {
        return parent::required();
    }
}
