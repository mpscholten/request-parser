<?php

namespace MPScholten\RequestParser;

class CommaSeparatedParser
{
    private $value;
    private $name;
    private $exceptionFactory;
    private $messageFactory;

    public function __construct(ExceptionFactory $exceptionFactory, MessageFactory $messageFactory, $name, $value)
    {
        $this->messageFactory = $messageFactory;
        $this->exceptionFactory = $exceptionFactory;
        $this->value = $value;
        $this->name = $name;
    }

    public function int()
    {
        return new CommaSeparatedIntParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }

    public function float()
    {
        return new CommaSeparatedFloatParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }

    public function string()
    {
        return new CommaSeparatedStringParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }

    public function dateTime()
    {
        return new CommaSeparatedDateTimeParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }

    public function json()
    {
        return new CommaSeparatedJsonParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }

    public function yesNoBoolean()
    {
        return new CommaSeparatedYesNoBooleanParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }

    public function boolean()
    {
        return new CommaSeparatedBooleanParser($this->exceptionFactory, $this->messageFactory, $this->name, $this->value);
    }
}
