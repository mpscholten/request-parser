<?php

namespace MPScholten\RequestParser;

/**
 * A flexible ExceptionFactory throwing the built-in `NotFoundException` and `InvalidValue` exceptions.
 */
class ExceptionFactory
{
    private $notFoundExceptionClass;
    private $invalidValueExceptionClass;

    public function __construct($notFoundExceptionClass = NotFoundException::class, $invalidValueExceptionClass = InvalidValueException::class)
    {
        $this->notFoundExceptionClass = $notFoundExceptionClass;
        $this->invalidValueExceptionClass = $invalidValueExceptionClass;
    }

    /**
     * @param string $message
     * @return NotFoundException|\Exception
     */
    public function createNotFoundException($message)
    {
        return new $this->notFoundExceptionClass($message);
    }

    /*
     * @param string $message
     * @return InvalidValueException|\Exception
     */
    public function createInvalidValueException($message)
    {
        return new $this->invalidValueExceptionClass($message);
    }
}
