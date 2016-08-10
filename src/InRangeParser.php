<?php

namespace MPScholten\RequestParser;

class InRangeParser extends AbstractValueParser
{
    /**
     * @var int|float $minValue
     */
    private $minValue;
    /**
     * @var int|float $maxValue
     */
    private $maxValue;
    private $type;

    public function __construct(Config $config, $name, $value, $minValue, $maxValue, $type)
    {
        $this->minValue = $minValue;
        $this->maxValue = $maxValue;
        $this->type = $type;
        parent::__construct($config, $name, $value);
    }

    protected function describe()
    {
        return "a" . ($this->type === 'int' ? 'n' : '' ) . " $this->type value between $this->minValue and $this->maxValue";
    }

    protected function parse($value)
    {
        if (!is_numeric($value)) {
            return null;
        }
        if ($this->type === 'int') {
            $value = (int) $value;
        } elseif ($this->type === 'float') {
            $value = (float) $value;
        } else {
            return null;
        }
        if ($value >= $this->minValue && $value <= $this->maxValue) {
            return $value;
        }
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
     * @throws \Exception
     * @return int|float
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
}
