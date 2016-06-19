<?php

namespace MPScholten\RequestParser;

class RequestParser
{
    /**
     * @var callable
     */
    private $readParameter;
    private $exceptionFactory;

    public function __construct(callable $readParameter, $exceptionFactory = null)
    {
        if ($exceptionFactory === null) {
            $exceptionFactory = function($parameter) {
                return new NotFoundException("Parameter $parameter not found");
            };
        }

        $this->readParameter = $readParameter;
        $this->exceptionFactory = $exceptionFactory;
    }

    protected final function readValue($name)
    {
        return call_user_func($this->readParameter, $name);
    }

    public function get($name)
    {
        return new TypeParser($this->exceptionFactory, $name, $this->readValue($name));
    }
}
