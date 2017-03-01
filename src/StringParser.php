<?php

namespace MPScholten\RequestParser;

use MPScholten\RequestParser\Validator\EmailParser;
use MPScholten\RequestParser\Validator\StringBetweenParser;
use MPScholten\RequestParser\Validator\StringLargerThanOrEqualToParser;
use MPScholten\RequestParser\Validator\StringLargerThanParser;
use MPScholten\RequestParser\Validator\StringSmallerThanOrEqualToParser;
use MPScholten\RequestParser\Validator\StringSmallerThanParser;
use MPScholten\RequestParser\Validator\UrlParser;

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
     * @param string $invalidValueMessage
     * @param string $notFoundMessage
     *
     * @return null
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
        return new TrimParser($this->config, $this->name, $this->value, TrimParser::TRIM);
    }

    public function leftTrim()
    {
        return new TrimParser($this->config, $this->name, $this->value, TrimParser::LEFT_TRIM);
    }
    
    public function rightTrim()
    {
        return new TrimParser($this->config, $this->name, $this->value, TrimParser::RIGHT_TRIM);
    }

    /**
     * @param int $minValue
     * @param int $maxValue
     * @return StringBetweenParser
     */
    public function between($minValue, $maxValue)
    {
        return new StringBetweenParser($this->config, $this->name, $this->value, $minValue, $maxValue);
    }

    /**
     * @param int $minValue
     * @return StringLargerThanParser
     */
    public function largerThan($minValue)
    {
        return new StringLargerThanParser($this->config, $this->name, $this->value, $minValue);
    }

    /**
     * @param int $minValue
     * @return StringLargerThanOrEqualToParser
     */
    public function largerThanOrEqualTo($minValue)
    {
        return new StringLargerThanOrEqualToParser($this->config, $this->name, $this->value, $minValue);
    }

    /**
     * @param int $maxValue
     * @return StringSmallerThanParser
     */
    public function smallerThan($maxValue)
    {
        return new StringSmallerThanParser($this->config, $this->name, $this->value, $maxValue);
    }

    /**
     * @param int $maxValue
     * @return StringSmallerThanOrEqualToParser
     */
    public function smallerThanOrEqualTo($maxValue)
    {
        return new StringSmallerThanOrEqualToParser($this->config, $this->name, $this->value, $maxValue);
    }
}
