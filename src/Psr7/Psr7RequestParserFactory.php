<?php

namespace MPScholten\RequestParser\Psr7;

use MPScholten\RequestParser\RequestParser;
use MPScholten\RequestParser\RequestParserFactory;
use Psr\Http\Message\ServerRequestInterface;

class Psr7RequestParserFactory implements RequestParserFactory
{
    private $request;
    private $config;

    public function __construct(ServerRequestInterface $request, $config = null)
    {
        $this->request = $request;
        $this->config = $config;
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

        return new RequestParser($readParameter, $this->config);
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

        return new RequestParser($readParameter, $this->config);
    }

    public function createCookieParser()
    {
        $cookies = $this->request->getCookieParams();
        $readParameter = function ($name) use ($cookies) {
            if (!isset($cookies[$name])) {
                return null;
            }

            return $cookies[$name];
        };

        return new RequestParser($readParameter, $this->config);
    }
}
