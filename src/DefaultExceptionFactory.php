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
    /**
     * @param string $parameterName
     * @return NotFoundException|\Exception
     */
    public final function createNotFoundException($parameterName)
    {
        $class = $this->getNotFoundExceptionClass();
        return new $class($this->generateNotFoundMessage($parameterName));
    }

    /**
     * Override this method to customize the error message
     */
    protected function generateNotFoundMessage($parameterName)
    {
        return "Parameter \"$parameterName\" not found";
    }

    /**
     * Override this method to customize the exception class
     * @return string
     */
    protected function getNotFoundExceptionClass()
    {
        return NotFoundException::class;
    }

    /**
     * @param string $parameterName
     * @param string $parameterValue
     * @param string $expected
     * @return InvalidValueException|\Exception
     */
    public final function createInvalidValueException($parameterName, $parameterValue, $expected)
    {
        $class = $this->getInvalidValueExceptionClass();
        return new $class($this->generateInvalidValueMessage($parameterName, $parameterValue, $expected));
    }

    /**
     * Override this method to customize the error message
     */
    protected function generateInvalidValueMessage($parameterName, $parameterValue, $expected)
    {
        return "Invalid value for parameter \"$parameterName\". Expected $expected, but got \"$parameterValue\"";
    }

    /**
     * Override this method to customize the exception class
     * @return string
     */
    protected function getInvalidValueExceptionClass()
    {
        return InvalidValueException::class;
    }
}
