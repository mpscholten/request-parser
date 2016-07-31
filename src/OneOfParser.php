<?php

namespace MPScholten\RequestParser;

class OneOfParser extends AbstractValueParser
{
    private $validValues;

    public function __construct(Config $config, $name, $value, array $validValues)
    {
        $this->validValues = $validValues;
        parent::__construct($config, $name, $value);
    }

    protected function describe()
    {
        return "one of " . implode(", ", $this->validValues);
    }

    protected function parse($value)
    {
        if (in_array($value, $this->validValues)) {
            return $value;
        } else {
            return null;
        }
    }

    /**
     * @param mixed $defaultValue
     * @return int
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return string
     */
    public function required($invalidValueMessage = null, $notFoundMessage = null)
    {
        return parent::required($invalidValueMessage, $notFoundMessage);
    }
}
