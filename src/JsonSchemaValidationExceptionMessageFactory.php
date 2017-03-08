<?php

namespace MPScholten\RequestParser;

class JsonSchemaValidationExceptionMessageFactory extends ExceptionMessageFactory
{
    public function createNotFoundMessage($parameterName)
    {
        return parent::createNotFoundMessage($parameterName);
    }

    public function createInvalidValueMessage($parameterName, $parameterValue, $expected)
    {
        return "Invalid value for parameter \"$parameterName\". Expected $expected, but got " . json_encode($parameterValue);
    }
}
