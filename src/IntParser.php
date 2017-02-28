<?php

namespace MPScholten\RequestParser;

use MPScholten\RequestParser\Validator\IntBetweenParser;
use MPScholten\RequestParser\Validator\IntLargerThanOrEqualToParser;
use MPScholten\RequestParser\Validator\IntLargerThanParser;
use MPScholten\RequestParser\Validator\IntSmallerThanOrEqualToParser;
use MPScholten\RequestParser\Validator\IntSmallerThanParser;

class IntParser extends AbstractValueParser
{
    protected function describe()
    {
        return "an integer";
    }

    protected function parse($value)
    {
        return is_numeric($value) ? (int)$value : null;
    }

    /**
     * @param int $defaultValue
     * @return int
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return int
     */
    public function required($invalidValueMessage = null, $notFoundMessage = null)
    {
        return parent::required($invalidValueMessage, $notFoundMessage);
    }

    /**
     * @param int $minValue
     * @param int $maxValue
     * @return IntBetweenParser
     */
    public function between($minValue, $maxValue)
    {
        return new IntBetweenParser($this->config, $this->name, $this->value, $minValue, $maxValue);
    }

    /**
     * @param int $minValue
     * @return IntLargerThanParser
     */
    public function largerThan($minValue)
    {
        return new IntLargerThanParser($this->config, $this->name, $this->value, $minValue);
    }

    /**
     * @param int $minValue
     * @return IntLargerThanOrEqualToParser
     */
    public function largerThanOrEqualTo($minValue)
    {
        return new IntLargerThanOrEqualToParser($this->config, $this->name, $this->value, $minValue);
    }

    /**
     * @param int $maxValue
     * @return IntSmallerThanParser
     */
    public function smallerThan($maxValue)
    {
        return new IntSmallerThanParser($this->config, $this->name, $this->value, $maxValue);
    }

    /**
     * @param int $maxValue
     * @return IntSmallerThanOrEqualToParser
     */
    public function smallerThanOrEqualTo($maxValue)
    {
        return new IntSmallerThanOrEqualToParser($this->config, $this->name, $this->value, $maxValue);
    }
}
