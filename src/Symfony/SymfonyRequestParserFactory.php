<?php

namespace MPScholten\RequestParser\Symfony;

use MPScholten\RequestParser\RequestParser;
use MPScholten\RequestParser\RequestParserFactory;
use Symfony\Component\HttpFoundation\Request;

class SymfonyRequestParserFactory implements RequestParserFactory
{
    private $request;
    private $exceptionFactory;
    private $messageFactory;

    public function __construct(Request $request, $exceptionFactory = null, $messageFactory = null)
    {
        $this->request = $request;
        $this->exceptionFactory = $exceptionFactory;
        $this->messageFactory = $messageFactory;
    }

    public function createQueryParser()
    {
        $readParameter = function ($name) {
            return $this->request->query->get($name, null);
        };

        return new RequestParser($readParameter, $this->exceptionFactory, $this->messageFactory);
    }

    public function createBodyParser()
    {
        $readParameter = function ($name) {
            return $this->request->request->get($name, null);
        };

        return new RequestParser($readParameter, $this->exceptionFactory, $this->messageFactory);
    }
}
