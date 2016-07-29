<?php

namespace MPScholten\RequestParser;

interface MessageFactory
{
    /**
     * Creates a new message based on the parameter name which is thrown when the parameter
     * is not found in the request.
     *
     * A possible implementation could be just:
     *
     *      return "$parameterName not found";
     *
     * @param string $parameterName
     * @return string
     */
    public function createNotFoundMessage($parameterName);

    /**
     * Creates a new message based on the parameter name, parameter value and a description
     * of what is expected ("an integer", "either yes or no", "a string").
     *
     * A possible implementation could be just:
     *
     *      return "$parameterName was invalid. Got $parameterValue but expected $expected";
     *
     * @param string $parameterName
     * @param string $parameterValue
     * @param string $expected
     * @return string
     */
    public function createInvalidValueMessage($parameterName, $parameterValue, $expected);

}
