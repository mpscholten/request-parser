<?php

namespace MPScholten\RequestParser;

class Config
{
    private $exceptionFactory;
    private $exceptionMessageFactory;

    public function __construct()
    {
        $this->exceptionFactory = null;
        $this->exceptionMessageFactory = null;
    }

    public function setExceptionFactory(ExceptionFactory $exceptionFactory)
    {
        $this->exceptionFactory = $exceptionFactory;
    }

    public function setExceptionMessageFactory(ExceptionMessageFactory $messageFactory)
    {
        $this->exceptionMessageFactory = $messageFactory;
    }

    public function getExceptionFactory()
    {
        if ($this->exceptionFactory === null) {
            $this->exceptionFactory = new ExceptionFactory();
        }

        return $this->exceptionFactory;
    }

    public function getExceptionMessageFactory()
    {
        if ($this->exceptionMessageFactory === null) {
            $this->exceptionMessageFactory = new ExceptionMessageFactory();
        }

        return $this->exceptionMessageFactory;
    }
}
