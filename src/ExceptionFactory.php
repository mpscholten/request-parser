<?php

namespace MPScholten\RequestParser;

interface ExceptionFactory
{
    public function createNotFoundException($parameterName);
    public function createInvalidValueException($parameterName, $parameterValue, $expected);
}
