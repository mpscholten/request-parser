<?php

// This example shows how to use this library with the Psr7 `ServerRequestInterface`
// To try out this example do the following:
// - Install dependencies: `composer install`
// - Start webserver: `cd examples && php -S localhost:8080`
// - Open in browser:
//   | http://localhost:8080/psr7.php?action=hello
//   | http://localhost:8080/psr7.php?action=hello&name=yourname
//   | http://localhost:8080/psr7.php?action=helloFromCookie
//   | http://localhost:8080/psr7.php?action=helloWithDefault
//   | http://localhost:8080/psr7.php?action=json&payload={%22a%22:1}

require __DIR__ . '/../vendor/autoload.php';

use MPScholten\RequestParser\Psr7\ControllerHelperTrait;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\Request;

$symfonyRequest = Request::createFromGlobals();
$symfonyRequest->cookies->add(["user", "John Doe"]);
$psr7Factory = new DiactorosFactory();
$request = $psr7Factory->createRequest($symfonyRequest);

class MyController
{
    use ControllerHelperTrait;

    public function __construct(ServerRequestInterface $request)
    {
        $this->initRequestParser($request);
    }

    public function hello()
    {
        $name = $this->queryParameter('name')->string()->required();

        return "Hello $name";
    }

    public function helloFromCookie()
    {
        $fullName = $this->cookieParameter('fullName')->string()->required();

        return "Hello $fullName";
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
}

$controller = new MyController($request);
$action = $request->getQueryParams()['action'];

try {
    echo $controller->$action();
} catch (\MPScholten\RequestParser\NotFoundException $e) {
    echo $e->getMessage();
}
