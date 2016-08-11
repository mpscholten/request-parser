<?php

namespace MPScholten\RequestParser;

abstract class AbstractInRangeParser extends AbstractValueParser
{
    /**
     * @var int|float $minValue
     */
    protected $minValue;
    /**
     * @var int|float $maxValue
     */
    protected $maxValue;

    public function __construct(Config $config, $name, $value, $minValue, $maxValue)
    {
        $this->minValue = $minValue;
        $this->maxValue = $maxValue;
        parent::__construct($config, $name, $value);
    }

    protected function parse($value)
    {
        if (!is_numeric($value)) {
            return null;
        }

        if ($this instanceof IntInRangeParser) {
            $value = (int) $value;
        } elseif ($this instanceof FloatInRangeParser) {
            $value = (float) $value;
        }

        if ($value >= $this->minValue && $value <= $this->maxValue) {
            return $value;
        }
    }
}
