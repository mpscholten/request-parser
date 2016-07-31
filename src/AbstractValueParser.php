<?php

namespace MPScholten\RequestParser;

/**
 * In case you want to add a new AbstractValueParser, make sure you override `defaultsTo` and `required` to add php doc blocks
 * to them for type hinting.
 */
abstract class AbstractValueParser
{
    protected $config;

    protected $name;
    private $unparsedValue;

    protected $value = null;
    private $invalid = false;
    private $notFound = false;

    public function __construct(Config $config, $name, $value)
    {
        $this->config = $config;
        $this->name = $name;
        $this->unparsedValue = $value;

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

    public function required($invalidValueMessage = null, $notFoundMessage = null)
    {
        if ($this->invalid) {
            if ($invalidValueMessage === null) {
                $invalidValueMessage = $this->config->getExceptionMessageFactory()->createInvalidValueMessage($this->name, $this->unparsedValue, $this->describe());
            }

            throw $this->config->getExceptionFactory()->createInvalidValueException($invalidValueMessage);
        } elseif ($this->notFound) {
            if ($notFoundMessage === null) {
                $notFoundMessage = $this->config->getExceptionMessageFactory()->createNotFoundMessage($this->name);
            }

            throw $this->config->getExceptionFactory()->createInvalidValueException($notFoundMessage);
        }

        return $this->value;
    }

    abstract protected function describe();
}
