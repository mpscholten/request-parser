<?php

namespace MPScholten\RequestParser\Symfony;

use MPScholten\RequestParser\RequestParser;
use MPScholten\RequestParser\RequestParserFactory;
use Symfony\Component\HttpFoundation\Request;

class SymfonyRequestParserFactory implements RequestParserFactory
{
    private $request;
    private $exceptionFactory;

    public function __construct(Request $request, $exceptionFactory = null)
    {
        $this->request = $request;
        $this->exceptionFactory = $exceptionFactory;
    }

    public function createQueryParser()
    {
        $readParameter = function ($name) {
            return $this->request->query->get($name, null);
        };

        return new RequestParser($readParameter, $this->exceptionFactory);
    }

    public function createBodyParser()
    {
        $readParameter = function ($name) {
            return $this->request->request->get($name, null);
        };

        return new RequestParser($readParameter, $this->exceptionFactory);
    }
}
