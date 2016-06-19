<?php

// This example shows how to use this library with a custom `Request` implementation (here $_GET and $_POST)
// To try out this example do the following:
// - Install dependencies: `composer install`
// - Start webserver: `cd examples && php -S localhost:8080`
// - Open in browser:
//   | http://localhost:8080/not-symfony.php?action=hello
//   | http://localhost:8080/not-symfony.php?action=hello&name=yourname
//   | http://localhost:8080/not-symfony.php?action=helloWithDefault
//   | http://localhost:8080/not-symfony.php?action=json&payload={%22a%22:1}

require __DIR__ . '/../vendor/autoload.php';

trait CustomControllerHelperTrait
{
    private $queryParser;
    private $bodyParser;

    protected final function initRequestParser()
    {
        $this->queryParser = new MPScholten\RequestParser\RequestParser(
            function ($parameterName) {
                if (isset($_GET[$parameterName])) {
                    return $_GET[$parameterName];
                }

                return null;
            },
            null
        );
        $this->bodyParser = new MPScholten\RequestParser\RequestParser(
            function ($parameterName) {
                if (isset($_POST[$parameterName])) {
                    return $_POST[$parameterName];
                }

                return null;
            },
            null
        );
    }

    protected function queryParameter($name)
    {
        return $this->queryParser->get($name);
    }

    protected function bodyParameter($name)
    {
        return $this->bodyParser->get($name);
    }

}

class MyController
{
    use CustomControllerHelperTrait;

    public function __construct()
    {
        $this->initRequestParser();
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
}

$controller = new MyController();
$action = $_GET['action'];

try {
    echo $controller->$action();
} catch (\MPScholten\RequestParser\NotFoundException $e) {
    echo $e->getMessage();
}
