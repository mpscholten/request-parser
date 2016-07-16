<?php

namespace MPScholten\RequestParser\Symfony;

use MPScholten\RequestParser\BaseControllerHelperTrait;

trait ControllerHelperTrait
{
    use BaseControllerHelperTrait;

    protected final function createRequestParser($request, $exceptionFactory)
    {
        return new SymfonyRequestParser($request, $exceptionFactory);
    }
}
