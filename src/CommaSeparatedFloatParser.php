<?php

namespace MPScholten\RequestParser;

class CommaSeparatedFloatParser extends AbstractValueParser
{
    protected function parse($value)
    {
        if (empty($value)) {
            return null;
        }
        $returnedIntArr = [];
        foreach (explode(',', $value) as $num) {
            if (!is_numeric(trim($num))) {
                return null;
            }
            $returnedIntArr[] = (float)trim($num);
        }
        return $returnedIntArr;
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
