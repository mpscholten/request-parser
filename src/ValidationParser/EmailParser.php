<?php

namespace MPScholten\RequestParser\ValidationParser;

use MPScholten\RequestParser\AbstractValueParser;

class EmailParser extends AbstractValueParser
{
    protected function describe()
    {
        return "a valid email address";
    }

    protected function parse($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            return null;
        }
        return (string) $value;
    }

    /**
     * @param string $defaultValue
     * @return string
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return string
     */
    public function required($invalidValueMessage = null, $notFoundMessage = null)
    {
        return parent::required($invalidValueMessage, $notFoundMessage);
    }

    /**
     * @param string $defaultValue
     * @return string
     */
    public function defaultsToIfEmpty($defaultValue)
    {
        if ($this->value === '') {
            return $defaultValue;
        }

        return $this->defaultsTo($defaultValue);
    }
}
