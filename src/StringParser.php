<?php

namespace MPScholten\RequestParser;

use MPScholten\RequestParser\Validator\EmailParser;
use MPScholten\RequestParser\Validator\StringLengthBetween;
use MPScholten\RequestParser\Validator\StringLengthLargerThanOrEqualToParser;
use MPScholten\RequestParser\Validator\StringLengthLargerThanParser;
use MPScholten\RequestParser\Validator\StringLengthSmallerThanOrEqualToParser;
use MPScholten\RequestParser\Validator\StringLengthSmallerThanParser;
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
     *
     * @return StringLengthBetween
     */
    public function lengthBetween($minValue, $maxValue)
    {
        return new StringLengthBetween($this->config, $this->name, $this->value, $minValue, $maxValue);
    }

    /**
     * @param int $minValue
     *
     * @return StringLengthLargerThanParser
     */
    public function lengthLargerThan($minValue)
    {
        return new StringLengthLargerThanParser($this->config, $this->name, $this->value, $minValue);
    }

    /**
     * @param int $minValue
     *
     * @return StringLengthLargerThanOrEqualToParser
     */
    public function lengthLargerThanOrEqualTo($minValue)
    {
        return new StringLengthLargerThanOrEqualToParser($this->config, $this->name, $this->value, $minValue);
    }

    /**
     * @param int $maxValue
     *
     * @return StringLengthSmallerThanParser
     */
    public function lengthSmallerThan($maxValue)
    {
        return new StringLengthSmallerThanParser($this->config, $this->name, $this->value, $maxValue);
    }

    /**
     * @param int $maxValue
     *
     * @return StringLengthSmallerThanOrEqualToParser
     */
    public function lengthSmallerThanOrEqualTo($maxValue)
    {
        return new StringLengthSmallerThanOrEqualToParser($this->config, $this->name, $this->value, $maxValue);
    }
}
