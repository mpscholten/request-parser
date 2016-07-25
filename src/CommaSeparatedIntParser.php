<?php

namespace MPScholten\RequestParser;

class CommaSeparatedIntParser extends AbstractValueParser
{
    protected function parse($value)
    {
        if (empty($value)) {
            return null;
        }
        $returnedIntArr = [];
        foreach (explode(',', $value) as $num) {
            if (!is_numeric($num)) {
                return null;
            }
            $returnedIntArr[] = (int)$num;
        }
        return $returnedIntArr;
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
