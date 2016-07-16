<?php

namespace MPScholten\RequestParser\Psr7;

use MPScholten\RequestParser\BaseControllerHelperTrait;

trait ControllerHelperTrait
{
    use BaseControllerHelperTrait;

    protected final function createRequestParser($request, $exceptionFactory)
    {
        return new Psr7RequestParser($request, $exceptionFactory);
    }
}
