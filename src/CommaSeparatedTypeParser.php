<?php
namespace MPScholten\RequestParser;
class CommaSeparatedTypeParser
{
    private $value;
    private $name;
    private $exceptionFactory;
    const INT = 'INT';
    const STRING = 'STRING';
    const FLOAT = 'FLOAT';
    const BOOLEAN = 'BOOLEAN';
    const YES_NO_BOOLEAN = 'YES_NO_BOOLEAN';
    const JSON = 'JSON';
    const DATE_TIME = 'DATE_TIME';
    public function __construct(callable $exceptionFactory, $name, $value)
    {
        $this->exceptionFactory = $exceptionFactory;
        $this->value = $value;
        $this->name = $name;
    }
    public function int()
    {
        return new CommaSeparatedParser($this->exceptionFactory, $this->name, $this->value, self::INT);
    }
    public function float()
    {
        return new CommaSeparatedParser($this->exceptionFactory, $this->name, $this->value, self::FLOAT);
    }
    public function string()
    {
        return new CommaSeparatedParser($this->exceptionFactory, $this->name, $this->value, self::STRING);
    }
    public function dateTime()
    {
        return new CommaSeparatedParser($this->exceptionFactory, $this->name, $this->value, self::DATE_TIME);
    }
    public function json()
    {
        return new CommaSeparatedParser($this->exceptionFactory, $this->name, $this->value, self::JSON);
    }
    public function yesNoBoolean()
    {
        return new CommaSeparatedParser($this->exceptionFactory, $this->name, $this->value, self::YES_NO_BOOLEAN);
    }
    public function boolean()
    {
        return new CommaSeparatedParser($this->exceptionFactory, $this->name, $this->value, self::BOOLEAN);
    }
}
