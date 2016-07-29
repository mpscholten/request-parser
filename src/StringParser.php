<?php

namespace MPScholten\RequestParser;

class StringParser extends AbstractValueParser
{
    protected function describe()
    {
        return "a text";
    }

    protected function parse($value)
    {
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

    public function url()
    {
        return new UrlParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }

    public function email()
    {
        return new EmailParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }
}
