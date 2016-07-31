<?php

namespace MPScholten\RequestParser;

/**
 * Used together with `LegacyExceptionFactory`
 */
class LegacyExceptionMessageFactory extends ExceptionMessageFactory
{
    public function createNotFoundMessage($parameterName)
    {
        return $parameterName;
    }

    public function createInvalidValueMessage($parameterName, $parameterValue, $expected)
    {
        return $parameterName;
    }
}
