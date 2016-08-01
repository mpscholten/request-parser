<?php

namespace MPScholten\RequestParser\Symfony;

use MPScholten\RequestParser\BaseControllerHelperTrait;

trait ControllerHelperTrait
{
    use BaseControllerHelperTrait;

    protected final function createRequestParserFactory($request, $config)
    {
        return new SymfonyRequestParserFactory($request, $config);
    }
}
