<?php

namespace MPScholten\RequestParser\Psr7;

use MPScholten\RequestParser\AbstractRequestParserFactory;
use MPScholten\RequestParser\RequestParser;
use MPScholten\RequestParser\RequestParserFactory;
use Psr\Http\Message\ServerRequestInterface;

class Psr7RequestParserFactory extends AbstractRequestParserFactory implements RequestParserFactory
{
    private $request;

    public function __construct(ServerRequestInterface $request, $config = null)
    {
        parent::__construct($config);
        $this->request = $request;
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
}
