<?php

namespace MPScholten\RequestParser;

class CommaSeparatedDateTimeParser extends AbstractValueParser
{
    protected function parse($value)
    {
        $dateTimeArr = explode(',', $value);
        foreach ($dateTimeArr as $key => $item) {
            try {
                $dateTimeArr[$key] =  new \DateTime($item);
            } catch (\Exception $e) {
                return null;
            }
        }
        return $dateTimeArr;
    }

    /**
     * @param \DateTime[] $defaultValue
     * @return \DateTime[]
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return \DateTime[]
     */
    public function required()
    {
        return parent::required();
    }
}
