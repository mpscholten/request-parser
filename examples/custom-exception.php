<?php

// This example shows how to use a custom exception

require __DIR__ . '/../vendor/autoload.php';

use MPScholten\RequestParser\Symfony\ControllerHelperTrait;

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

class CustomException extends Exception
{

}

class FriendlyExceptionFactory extends \MPScholten\RequestParser\DefaultExceptionFactory
{
    protected function generateNotFoundMessage($parameterName)
    {
        return "Looks like $parameterName is missing :)";
    }

    protected function generateInvalidValueMessage($parameterName, $parameterValue, $expected)
    {
        return "Whoops :) $parameterName seems to be invalid. We're looking for $expected but you provided '$parameterValue'";
    }

    protected function getNotFoundExceptionClass()
    {
        return CustomException::class;
    }

    protected function getInvalidValueExceptionClass()
    {
        return CustomException::class;
    }
}

class MyController
{
    use ControllerHelperTrait;

    public function __construct(\Symfony\Component\HttpFoundation\Request $request)
    {
        $this->initRequestParser($request, new FriendlyExceptionFactory());
    }

    public function hello()
    {
        $name = $this->queryParameter('name')->string()->required(); // Will now throw the CustomException

        return "Hello $name";
    }
}

$controller = new MyController($request);
$action = $request->get('action');

try {
    echo $controller->$action();
} catch (CustomException $e) {
    echo $e->getMessage();
}
