<?php

namespace MPScholten\RequestParser;

class CommaSeparatedYesNoBooleanParser extends AbstractValueParser
{
    protected function describe()
    {
        return "a comma separated list of yes or no";
    }

    protected function parse($value)
    {
        $booleanArr = explode(',', $value);
        foreach ($booleanArr as $key => $item) {
            if (strtoupper($item) === 'YES' || $item === 'Y') {
                $booleanArr[$key] =  true;
                continue;
            }
            if (strtoupper($item) === 'NO' || $item === 'N') {
                $booleanArr[$key] =  false;
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
