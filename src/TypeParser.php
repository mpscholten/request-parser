<?php

namespace MPScholten\RequestParser;

use MPScholten\RequestParser\Validator\OneOfParser;

class TypeParser
{
    private $value;
    private $name;
    private $config;

    public function __construct(Config $config, $name, $value)
    {
        $this->value = $value;
        $this->name = $name;
        $this->config = $config;
    }

    public function int()
    {
        return new IntParser($this->config, $this->name, $this->value);
    }

    public function float()
    {
        return new FloatParser($this->config, $this->name, $this->value);
    }

    public function string()
    {
        return new StringParser($this->config, $this->name, $this->value);
    }

    public function oneOf(array $validValues)
    {
        return new OneOfParser($this->config, $this->name, $this->value, $validValues);
    }

    public function dateTime()
    {
        return new DateTimeParser($this->config, $this->name, $this->value);
    }

    public function json()
    {
        return new JsonParser($this->config, $this->name, $this->value);
    }

    public function yesNoBoolean()
    {
        return new YesNoBooleanParser($this->config, $this->name, $this->value);
    }

    public function boolean()
    {
        return new BooleanParser($this->config, $this->name, $this->value);
    }

    public function commaSeparated()
    {
        return new CommaSeparatedParser($this->config, $this->name, $this->value);
    }
}
