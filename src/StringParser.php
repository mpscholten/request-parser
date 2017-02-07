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
        return new UrlParser($this->config, $this->name, $this->value);
    }

    public function email()
    {
        return new EmailParser($this->config, $this->name, $this->value);
    }

    public function trim()
    {
        return new TrimParser($this->config, $this->name, $this->value, TrimType::TRIM);
    }

    public function leftTrim()
    {
        return new TrimParser($this->config, $this->name, $this->value, TrimType::LEFT_TRIM);
    }
    
    public function rightTrim()
    {
        return new TrimParser($this->config, $this->name, $this->value, TrimType::RIGHT_TRIM);
    }
}
