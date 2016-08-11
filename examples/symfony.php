<?php

// This example shows how to use this library with `symfony/http-foundation` `Request`
// To try out this example do the following:
// - Install dependencies: `composer install`
// - Start webserver: `cd examples && php -S localhost:8080`
// - Open in browser:
//   | http://localhost:8080/symfony.php?action=hello
//   | http://localhost:8080/symfony.php?action=hello&name=yourname
//   | http://localhost:8080/symfony.php?action=helloWithDefault
//   | http://localhost:8080/symfony.php?action=json&payload={%22a%22:1}
//   | http://localhost:8080/symfony.php?action=intArray&userIds=21,22,23
//   | http://localhost:8080/symfony.php?action=dateTimeArray&timestamps=2016-01-01%2000:00:00,2016-12-31%2023:59:59
//   | http://localhost:8080/symfony.php?action=booleanArray&answers=true,false,true
//   | http://localhost:8080/symfony.php?action=jsonArray&events=[{"a":1}]

require __DIR__ . '/../vendor/autoload.php';

use MPScholten\RequestParser\Symfony\ControllerHelperTrait;

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

class MyController
{
    use ControllerHelperTrait;

    public function __construct(\Symfony\Component\HttpFoundation\Request $request)
    {
        $this->initRequestParser($request);
    }

    public function inRange()
    {
        $name = $this->queryParameter('name')->int()->inRange(1, 5)->required();

        return "Hello $name";
    }

    public function hello()
    {
        $name = $this->queryParameter('name')->string()->required();

        return "Hello $name";
    }

    public function helloWithDefault()
    {
        $name = $this->queryParameter('name')->string()->defaultsTo('unknown');

        return "Hello $name";
    }

    public function json()
    {
        $payload = $this->queryParameter('payload')->json()->required();

        return print_r($payload, true);
    }

    public function intArray()
    {
        $userIds = $this->queryParameter('userIds')->commaSeparated()->int()->required();
        return print_r($userIds, true);
    }

    public function dateTimeArray()
    {
        $userIds = $this->queryParameter('timestamps')->commaSeparated()->dateTime()->required();
        return print_r($userIds, true);
    }

    public function booleanArray()
    {
        $userIds = $this->queryParameter('answers')->commaSeparated()->boolean()->required();
        return print_r($userIds, true);
    }

    public function jsonArray()
    {
        $userIds = $this->queryParameter('events')->commaSeparated()->json()->required();
        return print_r($userIds, true);
    }
}

$controller = new MyController($request);
$action = $request->get('action');

try {
    echo $controller->$action();
} catch (\MPScholten\RequestParser\NotFoundException $e) {
    echo $e->getMessage();
}
