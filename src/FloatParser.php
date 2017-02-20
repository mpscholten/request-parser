<?php

namespace MPScholten\RequestParser;

use MPScholten\RequestParser\ValidationParser\FloatBetweenParser;
use MPScholten\RequestParser\ValidationParser\FloatLargerThanOrEqualToParser;
use MPScholten\RequestParser\ValidationParser\FloatLargerThanParser;
use MPScholten\RequestParser\ValidationParser\FloatSmallerThanOrEqualToParser;
use MPScholten\RequestParser\ValidationParser\FloatSmallerThanParser;

class FloatParser extends AbstractValueParser
{
    protected function describe()
    {
        return "a floating point number";
    }

    protected function parse($value)
    {
        return is_numeric($value) ? (float)$value : null;
    }

    /**
     * @param float $defaultValue
     * @return float
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return float
     */
    public function required($invalidValueMessage = null, $notFoundMessage = null)
    {
        return parent::required($invalidValueMessage, $notFoundMessage);
    }

    /**
     * @param float $minValue
     * @param float $maxValue
     * @return FloatBetweenParser
     */
    public function between($minValue, $maxValue)
    {
        return new FloatBetweenParser($this->config, $this->name, $this->value, $minValue, $maxValue);
    }

    /**
     * @param int $minValue
     * @return FloatLargerThanParser
     */
    public function largerThan($minValue)
    {
        return new FloatLargerThanParser($this->config, $this->name, $this->value, $minValue);
    }

    /**
     * @param int $minValue
     * @return FloatLargerThanOrEqualToParser
     */
    public function largerThanOrEqualTo($minValue)
    {
        return new FloatLargerThanOrEqualToParser($this->config, $this->name, $this->value, $minValue);
    }

    /**
     * @param int $maxValue
     * @return FloatSmallerThanParser
     */
    public function smallerThan($maxValue)
    {
        return new FloatSmallerThanParser($this->config, $this->name, $this->value, $maxValue);
    }

    /**
     * @param int $maxValue
     * @return FloatSmallerThanOrEqualToParser
     */
    public function smallerThanOrEqualTo($maxValue)
    {
        return new FloatSmallerThanOrEqualToParser($this->config, $this->name, $this->value, $maxValue);
    }
}
