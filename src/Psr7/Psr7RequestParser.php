<?php

namespace MPScholten\RequestParser\Psr7;

use MPScholten\RequestParser\RequestParser;
use Psr\Http\Message\ServerRequestInterface;

class Psr7RequestParser
{
    private $request;
    private $exceptionFactory;


    public function __construct(ServerRequestInterface $request, $exceptionFactory = null)
    {
        $this->request = $request;
        $this->exceptionFactory = $exceptionFactory;
    }

    public function createQueryParser()
    {
        $query = $this->request->getQueryParams();

        $readParameter = function ($name) use ($query) {
            if (!isset($query[$name])) {
                return null;
            }

            return $query[$name];
        };

        return new RequestParser($readParameter, $this->exceptionFactory);
    }

    public function createBodyParser()
    {
        $body = $this->request->getParsedBody();

        $readParameter = function ($name) use ($body) {
            if (!isset($body[$name])) {
                return null;
            }

            return $body[$name];
        };

        return new RequestParser($readParameter, $this->exceptionFactory);
    }
}
