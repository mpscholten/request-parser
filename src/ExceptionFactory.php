<?php

namespace MPScholten\RequestParser;

interface ExceptionFactory
{
    /**
     * Creates a new exception based on the message
     *
     * A possible implementation could be just:
     *
     *      return new Exception($message);
     *
     * @param string $message
     * @return \Exception
     */
    public function createNotFoundException($message);

    /**
     * Creates a new exception based on the message
     *
     * A possible implementation could be just:
     *
     *      return new Exception($message);
     *
     * @param string $parameterName
     * @return \Exception
     */
    public function createInvalidValueException($message);
}
