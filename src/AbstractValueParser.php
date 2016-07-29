<?php

namespace MPScholten\RequestParser;

/**
 * In case you want to add a new AbstractValueParser, make sure you override `defaultsTo` and `required` to add php doc blocks
 * to them for type hinting.
 */
abstract class AbstractValueParser
{
    protected $exceptionFactory;

    protected $name;
    private $unparsedValue;

    protected $value = null;
    private $invalid = false;
    private $notFound = false;

    public function __construct(ExceptionFactory $exceptionFactory, $name, $value)
    {
        $this->name = $name;
        $this->unparsedValue = $value;
        $this->exceptionFactory = $exceptionFactory;

        if ($value === null) {
            $this->notFound = true;
        } else {
            $parsed = $this->parse($value);
            if ($parsed === null) {
                $this->invalid = true;
            } else {
                $this->value = $parsed;
            }
        }
    }

    abstract protected function parse($value);

    public function defaultsTo($defaultValue)
    {
        return ($this->notFound || $this->invalid) ? $defaultValue : $this->value;
    }

    public function required()
    {
        if ($this->invalid) {
            throw $this->createInvalidValueException();
        } elseif ($this->notFound) {
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
