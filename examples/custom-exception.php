<?php

// This example shows how to use a custom exception

require __DIR__ . '/../vendor/autoload.php';

use MPScholten\RequestParser\ExceptionFactory;
use MPScholten\RequestParser\ExceptionMessageFactory;
use MPScholten\RequestParser\Symfony\ControllerHelperTrait;

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

class CustomException extends Exception
{

}

class FriendlyExceptionMessageFactory extends ExceptionMessageFactory
{
    public function createNotFoundMessage($parameterName)
    {
        return "Looks like $parameterName is missing :)";
    }

    public function createInvalidValueMessage($parameterName, $parameterValue, $expected)
    {
        return "Whoops :) $parameterName seems to be invalid. We're looking for $expected but you provided '$parameterValue'";
    }
}

class MyController
{
    use ControllerHelperTrait;

    public function __construct(\Symfony\Component\HttpFoundation\Request $request)
    {
        $config = new \MPScholten\RequestParser\Config();
        $config->setExceptionFactory(new ExceptionFactory(CustomException::class, CustomException::class));
        $config->setExceptionMessageFactory(new FriendlyExceptionMessageFactory());

        $this->initRequestParser($request, $config);
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
