<?php

namespace MPScholten\RequestParser\Validator;

use MPScholten\RequestParser\AbstractValueParser;
use MPScholten\RequestParser\Config;

abstract class AbstractLargerThanOrEqualToParser extends AbstractValueParser
{
    protected $minValue;

    public function __construct(Config $config, $name, $value, $minValue)
    {
        $this->minValue = $minValue;
        parent::__construct($config, $name, $value);
    }

    protected function parse($value)
    {
        if ($value >= $this->minValue) {
            return $value;
        }
        return null;
    }
}
