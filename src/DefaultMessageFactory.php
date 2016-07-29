<?php

namespace MPScholten\RequestParser;

class DefaultMessageFactory implements MessageFactory
{
    /**
     * Override this method to customize the error message
     */
    public function createNotFoundMessage($parameterName)
    {
        return "Parameter \"$parameterName\" not found";
    }

    /**
     * Override this method to customize the error message
     */
    public function createInvalidValueMessage($parameterName, $parameterValue, $expected)
    {
        return "Invalid value for parameter \"$parameterName\". Expected $expected, but got \"$parameterValue\"";
    }
}
