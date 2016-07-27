<?php

namespace MPScholten\RequestParser;

class DefaultExceptionFactory implements ExceptionFactory
{
    public function createNotFoundException($parameterName)
    {
        $class = $this->getNotFoundExceptionClass();
        return new $class($this->generateNotFoundMessage($parameterName));
    }

    /**
     * Override this method to customize the error message
     */
    protected function generateNotFoundMessage($parameterName)
    {
        return "Parameter \"$parameterName\" not found";
    }

    protected function getNotFoundExceptionClass()
    {
        return NotFoundException::class;
    }

    public function createInvalidValueException($parameterName, $parameterValue, $expected)
    {
        $class = $this->getInvalidValueExceptionClass();
        return new $class($this->generateInvalidValueMessage($parameterName, $parameterValue, $expected));
    }

    /**
     * Override this method to customize the error message
     */
    protected function generateInvalidValueMessage($parameterName, $parameterValue, $expected)
    {
        return "Invalid value for parameter \"$parameterName\". Expected $expected, but got \"$parameterValue\".";
    }

    protected function getInvalidValueExceptionClass()
    {
        return InvalidValueException::class;
    }
}
