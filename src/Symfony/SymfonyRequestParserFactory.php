<?php

namespace MPScholten\RequestParser\Symfony;

use MPScholten\RequestParser\AbstractRequestParserFactory;
use MPScholten\RequestParser\RequestParser;
use MPScholten\RequestParser\RequestParserFactory;
use Symfony\Component\HttpFoundation\Request;

class SymfonyRequestParserFactory extends AbstractRequestParserFactory implements RequestParserFactory
{
    private $request;

    public function __construct(Request $request, $config = null)
    {
        parent::__construct($config);
        $this->request = $request;
    }

    public function createQueryParser()
    {
        $readParameter = function ($name) {
            return $this->request->query->get($name, null);
        };

        return new RequestParser($readParameter, $this->config);
    }

    public function createBodyParser()
    {
        $readParameter = function ($name) {
            return $this->request->request->get($name, null);
        };

        return new RequestParser($readParameter, $this->config);
    }
}
