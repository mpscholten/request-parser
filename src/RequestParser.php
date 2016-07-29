<?php

namespace MPScholten\RequestParser;

class RequestParser
{
    /**
     * @var callable
     */
    private $readParameter;
    private $messageFactory;
    private $exceptionFactory;

    public function __construct(callable $readParameter, $exceptionFactory = null, $messageFactory = null)
    {
        if ($exceptionFactory === null) {
            $exceptionFactory = new ExceptionFactory();
        } elseif (is_callable($exceptionFactory)) {
            if ($messageFactory !== null) {
                $exceptionClass = get_class($exceptionFactory('some parameter'));
                throw new \RuntimeException("To use a custom MessageFactory, you have to upgrade the ExceptionFactory. Currently you're providing a callable. This way is deprecated. Just pass `new ExceptionFactory($exceptionClass::class)`");
            }

            $exceptionFactory = new LegacyExceptionFactory($exceptionFactory);
            $messageFactory = new LegacyMessageFactory();
        }

        if ($messageFactory === null) {
            $messageFactory = new MessageFactory();
        }

        $this->readParameter = $readParameter;
        $this->exceptionFactory = $exceptionFactory;
        $this->messageFactory = $messageFactory;
    }

    protected final function readValue($name)
    {
        return call_user_func($this->readParameter, $name);
    }

    public function get($name)
    {
        return new TypeParser($this->exceptionFactory, $this->messageFactory, $name, $this->readValue($name));
    }
}
