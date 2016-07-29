<?php

namespace MPScholten\RequestParser;

/**
 * A flexible ExceptionFactory throwing the built-in `NotFoundException` and `InvalidValue` exceptions.
 *
 * To customize the error message: Override `generateNotFoundMessage` or `generateInvalidValueMessage`
 * To customize the exception class: Override `getNotFoundExceptionClass` or `getInvalidValueExceptionClass`
 *
 * Example with custom error messages:
 *
 *      class FriendlyExceptionFactory extends DefaultExceptionFactory
 *      {
 *          protected function generateNotFoundMessage($parameterName)
 *          {
 *              return "$parameterName not found :)";
 *          }
 *
 *          protected function generateInvalidValueMessage($parameterName, $parameterValue, $expected)
 *          {
 *              return "$parameterName is invalid :)";
 *          }
 *      }
 */
class DefaultExceptionFactory implements ExceptionFactory
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
    public final function createNotFoundException($message)
    {
        return new $this->notFoundExceptionClass($message);
    }

    /*
     * @param string $message
     * @return InvalidValueException|\Exception
     */
    public final function createInvalidValueException($message)
    {
        return new $this->invalidValueExceptionClass($message);
    }
}
