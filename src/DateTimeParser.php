<?php

namespace MPScholten\RequestParser;

class DateTimeParser extends AbstractValueParser
{
    protected function parse($value)
    {
        if ($value === '') {
            return null;
        }

        try {
            return new \DateTime($value);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param \DateTime $defaultValue
     * @return \DateTime
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return \DateTime
     */
    public function required()
    {
        return parent::required();
    }
}
