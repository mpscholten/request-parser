<?php

namespace MPScholten\RequestParser;

/**
 * TODO: Somehow tell the user that this is deprecated
 */
class LegacyExceptionFactory implements ExceptionFactory
{
    private $closure;

    public function __construct($closure)
    {
        $this->closure = $closure;
    }

    public function createNotFoundException($parameterName)
    {
        return call_user_func($this->closure, $parameterName);
    }

    public function createInvalidValueException($parameterName, $parameterValue, $expected)
    {
        return call_user_func($this->closure, $parameterName);
    }
}
