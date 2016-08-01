<?php

namespace MPScholten\RequestParser;

class UrlParser extends AbstractValueParser
{
    protected function describe()
    {
        return "a valid URL";
    }

    protected function parse($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
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
