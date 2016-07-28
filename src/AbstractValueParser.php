<?php

namespace MPScholten\RequestParser;

/**
 * In case you want to add a new AbstractValueParser, make sure you override `defaultsTo` and `required` to add php doc blocks
 * to them for type hinting.
 */
abstract class AbstractValueParser
{
    protected $exceptionFactory;
    protected $value;
    protected $name;

    public function __construct(callable $exceptionFactory, $name, $value)
    {
        $this->value = is_null($value) ? null : $this->parse($value);
        $this->name = $name;
        $this->exceptionFactory = $exceptionFactory;
    }

    abstract protected function parse($value);

    public function defaultsTo($defaultValue)
    {
        return is_null($this->value) ? $defaultValue : $this->value;
    }

    public function required()
    {
        if (is_null($this->value)) {
            throw $this->createNotFoundException();
        }

        return $this->value;
    }

    private function createNotFoundException()
    {
        return call_user_func($this->exceptionFactory, $this->name);
    }
}
