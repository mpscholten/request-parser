<?php

namespace MPScholten\RequestParser\Validator;

use MPScholten\RequestParser\AbstractValueParser;
use MPScholten\RequestParser\Config;

abstract class AbstractSmallerThanOrEqualToParser extends AbstractValueParser
{
    protected $maxValue;

    public function __construct(Config $config, $name, $value, $maxValue)
    {
        $this->maxValue = $maxValue;
        parent::__construct($config, $name, $value);
    }

    protected function parse($value)
    {
        if ($value <= $this->maxValue) {
            return $value;
        }
        return null;
    }
}
