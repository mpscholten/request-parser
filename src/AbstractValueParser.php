<?php

namespace MPScholten\RequestParser;

/**
 * In case you want to add a new AbstractValueParser, make sure you override `defaultsTo` and `required` to add php doc blocks
 * to them for type hinting.
 */
abstract class AbstractValueParser
{
    protected $exceptionFactory;
    protected $messageFactory;

    protected $name;
    private $unparsedValue;

    protected $value = null;
    private $invalid = false;
    private $notFound = false;

    public function __construct(ExceptionFactory $exceptionFactory, MessageFactory $messageFactory, $name, $value)
    {
        $this->name = $name;
        $this->unparsedValue = $value;
        $this->exceptionFactory = $exceptionFactory;
        $this->messageFactory = $messageFactory;

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
        $messageFactory = new StaticMessageFactory($notFoundMessage, $invalidValueMessage, $this->messageFactory);

        if ($this->invalid) {
            $message = $messageFactory->createInvalidValueMessage($this->name, $this->unparsedValue, $this->describe());
            throw $this->exceptionFactory->createInvalidValueException($message);
        } elseif ($this->notFound) {
            $message = $messageFactory->createNotFoundMessage($this->name);
            throw $this->exceptionFactory->createInvalidValueException($message);
        }

        return $this->value;
    }

    abstract protected function describe();
}
