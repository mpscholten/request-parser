<?php

namespace MPScholten\RequestParser;

class TypeParser
{
    private $value;
    private $name;
    private $messageFactory;
    private $exceptionFactory;

    public function __construct(ExceptionFactory $exceptionFactory, MessageFactory $messageFactory, $name, $value)
    {
        $this->messageFactory = $messageFactory;
        $this->exceptionFactory = $exceptionFactory;
        $this->value = $value;
        $this->name = $name;
    }

    public function int()
    {
        return new IntParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }

    public function float()
    {
        return new FloatParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }

    public function string()
    {
        return new StringParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }

    public function oneOf(array $validValues)
    {
        return new OneOfParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value, $validValues);
    }

    public function dateTime()
    {
        return new DateTimeParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }

    public function json()
    {
        return new JsonParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }

    public function yesNoBoolean()
    {
        return new YesNoBooleanParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }

    public function boolean()
    {
        return new BooleanParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }

    public function commaSeparated()
    {
        return new CommaSeparatedParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }
}
