<?php

namespace MPScholten\RequestParser;

class MessageFactory
{

    /**
     * Override this method to customize the error message.
     *
     * @param string $parameterName
     * @return string
     */
    public function createNotFoundMessage($parameterName)
    {
        return "Parameter \"$parameterName\" not found";
    }

    /**
     * Override this method to customize the error message.
     *
     * @param string $parameterName
     * @param string $parameterValue
     * @param string $expected
     * @return string
     */
    public function createInvalidValueMessage($parameterName, $parameterValue, $expected)
    {
        return "Invalid value for parameter \"$parameterName\". Expected $expected, but got \"$parameterValue\"";
    }

}
