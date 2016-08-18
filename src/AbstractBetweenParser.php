<?php

namespace MPScholten\RequestParser;

abstract class AbstractBetweenParser extends AbstractValueParser
{
    protected $minValue;
    protected $maxValue;

    public function __construct(Config $config, $name, $value, $minValue, $maxValue)
    {
        $this->minValue = $minValue;
        $this->maxValue = $maxValue;
        parent::__construct($config, $name, $value);
    }

    protected function parse($value)
    {
        if ($value >= $this->minValue && $value <= $this->maxValue) {
            return $value;
        }
        return null;
    }
}
