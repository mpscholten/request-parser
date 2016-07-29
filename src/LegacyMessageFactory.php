<?php

namespace MPScholten\RequestParser;

/**
 * Used together with `LegacyExceptionFactory`
 */
class LegacyMessageFactory implements MessageFactory
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
