<?php

namespace MPScholten\RequestParser;

/**
 * TODO: Somehow tell the user that this is deprecated
 *
 * In a previous version of the library you could customize the error message with a simple closure like:
 *
 *      class MyController
 *      {
 *          use \MPScholten\RequestParser\Symfony\ControllerHelperTrait;
 *
 *          public function __construct(Request $request)
 *          {
 *              $this->initRequestParser($request, function($parameter) {
 *                  throw new CustomException($message);
 *              });
 *          }
 *      }
 *
 * This class transforms such a closure into a `ExceptionFactory` to keep b.c.
 *
 * For b.c. reasons invalid values are handled like not found values, so for
 * an integer parameter with value "invalidInt" it just says "Parameter not found"
 * instead of "Invalid value for integer".
 */
class LegacyExceptionFactory extends ExceptionFactory
{
    private $closure;

    public function __construct(callable $closure)
    {
        $this->closure = $closure;
    }

    public function createNotFoundException($message)
    {
        return call_user_func($this->closure, $message);
    }

    public function createInvalidValueException($message)
    {
        return call_user_func($this->closure, $message);
    }
}
