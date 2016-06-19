<?php

// This example shows how to use a custom exception

require __DIR__ . '/../vendor/autoload.php';

use MPScholten\RequestParser\Symfony\ControllerHelperTrait;

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

class CustomException extends Exception
{

}

class MyController
{
    use ControllerHelperTrait;

    public function __construct(\Symfony\Component\HttpFoundation\Request $request)
    {
        $customExceptionFactory = function($parameterName) {
            throw new CustomException($parameterName);
        };
        $this->initRequestParser($request, $customExceptionFactory);
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
