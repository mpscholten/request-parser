<?php

namespace MPScholten\RequestParser\Psr7;

use MPScholten\RequestParser\BaseControllerHelperTrait;

trait ControllerHelperTrait
{
    use BaseControllerHelperTrait;

    protected final function createRequestParserFactory($request, $exceptionFactory)
    {
        return new Psr7RequestParserFactory($request, $exceptionFactory);
    }
}
