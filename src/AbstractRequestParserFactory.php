<?php

namespace MPScholten\RequestParser;

abstract class AbstractRequestParserFactory
{
    protected $config;

    public function __construct($config = null)
    {
        $this->config = $config;
    }

    public function createCookieParser()
    {
        $readParameter = function ($name) {
            return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
        };
        return new RequestParser($readParameter, $this->config);
    }
}
