<?php

namespace MPScholten\RequestParser;

/**
 * In case you want to add a new AbstractValueParser, make sure you override `defaultsTo` and `required` to add php doc blocks
 * to them for type hinting.
 */
abstract class AbstractValueParser
{
    private $exceptionFactory;

    protected $value;
    private $invalid;
    private $unparsedValue;
    private $name;

    public function __construct(ExceptionFactory $exceptionFactory, $name, $value)
    {
        $this->name = $name;
        $this->unparsedValue = $value;
        $this->exceptionFactory = $exceptionFactory;

        $this->invalid = false;
        if ($value === null) {
            $this->value = null;
        } else {
            $this->value = $this->parse($value);
            if ($this->value === null) {
                $this->invalid = true;
            }
        }
    }

    abstract protected function parse($value);

    public function defaultsTo($defaultValue)
    {
        return is_null($this->value) ? $defaultValue : $this->value;
    }

    public function required()
    {
        if ($this->invalid) {
            throw $this->createInvalidValueException();
        } elseif (is_null($this->value)) {
            throw $this->createNotFoundException();
        }

        return $this->value;
    }

    private function createNotFoundException()
    {
        return $this->exceptionFactory->createNotFoundException($this->name);
    }

    final protected function createInvalidValueException()
    {
        return $this->exceptionFactory->createInvalidValueException($this->name, $this->unparsedValue, $this->describe());
    }

    abstract protected function describe();
}
