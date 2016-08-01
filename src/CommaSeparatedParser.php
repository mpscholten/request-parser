<?php

namespace MPScholten\RequestParser;

class CommaSeparatedParser
{
    private $config;
    private $value;
    private $name;

    public function __construct(Config $config, $name, $value)
    {
        $this->config = $config;
        $this->value = $value;
        $this->name = $name;
    }

    public function int()
    {
        return new CommaSeparatedIntParser($this->config, $this->name, $this->value);
    }

    public function float()
    {
        return new CommaSeparatedFloatParser($this->config, $this->name, $this->value);
    }

    public function string()
    {
        return new CommaSeparatedStringParser($this->config, $this->name, $this->value);
    }

    public function dateTime()
    {
        return new CommaSeparatedDateTimeParser($this->config, $this->name, $this->value);
    }

    public function json()
    {
        return new CommaSeparatedJsonParser($this->config, $this->name, $this->value);
    }

    public function yesNoBoolean()
    {
        return new CommaSeparatedYesNoBooleanParser($this->config, $this->name, $this->value);
    }

    public function boolean()
    {
        return new CommaSeparatedBooleanParser($this->config, $this->name, $this->value);
    }
}
