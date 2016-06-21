<?php

namespace MPScholten\RequestParser;

class TypeParser
{
    private $value;
    private $name;
    private $exceptionFactory;

    public function __construct(callable $exceptionFactory, $name, $value)
    {
        $this->exceptionFactory = $exceptionFactory;
        $this->value = $value;
        $this->name = $name;
    }

    public function int()
    {
        return new IntParser($this->exceptionFactory, $this->name, $this->value);
    }

    public function float()
    {
        return new FloatParser($this->exceptionFactory, $this->name, $this->value);
    }

    public function string()
    {
        return new StringParser($this->exceptionFactory, $this->name, $this->value);
    }

    public function oneOf(array $validValues)
    {
        return new OneOfParser($this->exceptionFactory, $this->name, $this->value, $validValues);
    }

    public function dateTime()
    {
        return new DateTimeParser($this->exceptionFactory, $this->name, $this->value);
    }

    public function json()
    {
        return new JsonParser($this->exceptionFactory, $this->name, $this->value);
    }

    public function yesNoBoolean()
    {
        return new YesNoBooleanParser($this->exceptionFactory, $this->name, $this->value);
    }
}
