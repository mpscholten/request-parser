<?php

namespace MPScholten\RequestParser;

interface ExceptionFactory
{
    /**
     * Creates a new exception based on the parameter name which is thrown when the parameter
     * is not found in the request.
     *
     * A possible implementation could be just:
     *
     *      return new Exception("$parameterName not found");
     *
     * @param string $parameterName
     * @return \Exception
     */
    public function createNotFoundException($parameterName);

    /**
     * Creates a new exception based on the parameter name, parameter value and a description
     * of what is expected ("an integer", "either yes or no", "a string").
     *
     * A possible implementation could be just:
     *
     *      return new Exception("$parameterName was invalid. Got $parameterValue but expected $expected");
     *
     * @param string $parameterName
     * @return \Exception
     */
    public function createInvalidValueException($parameterName, $parameterValue, $expected);
}
