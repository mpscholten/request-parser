<?php

namespace MPScholten\RequestParser;

class CommaSeparatedBooleanParser extends AbstractValueParser
{
    protected function parse($value)
    {
        $booleanArr = explode(',', $value);
        foreach ($booleanArr as $key => $item) {
            if (strtoupper($item) === 'TRUE' || $item === '1') {
                $booleanArr[$key] = true;
                continue;
            }
            if (strtoupper($item) === 'FALSE' || $item === '0') {
                $booleanArr[$key] = false;
                continue;
            }
            return null;
        }
        return $booleanArr;
    }

    /**
     * @param boolean[] $defaultValue
     * @return boolean[]
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return boolean[]
     */
    public function required()
    {
        return parent::required();
    }
}
