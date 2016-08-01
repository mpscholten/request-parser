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

class CustomRequestParserFactory implements \MPScholten\RequestParser\RequestParserFactory
{
    /**
     * @var array
     */
    private $request;
    private $config;

    public function __construct(array $request, $config)
    {
        $this->request = $request;
        $this->config = $config;
    }

    public function createQueryParser()
    {
        return new MPScholten\RequestParser\RequestParser(
            function ($parameterName) {
                if (isset($this->request[$parameterName])) {
                    return $this->request[$parameterName];
                }

                return null;
            },
            $this->config
        );
    }

    public function createBodyParser()
    {
        return new MPScholten\RequestParser\RequestParser(
            function ($parameterName) {
                if (isset($this->request[$parameterName])) {
                    return $this->request[$parameterName];
                }

                return null;
            },
            $this->config
        );
    }
}

trait CustomControllerHelperTrait
{
    use \MPScholten\RequestParser\BaseControllerHelperTrait;

    /**
     * Will be called during the `initRequestParser()` call in `MyController`
     */
    protected final function createRequestParserFactory($request, $config)
    {
        return new CustomRequestParserFactory($request, $config);
    }
}

class MyController
{
    use CustomControllerHelperTrait;

    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $request = $_GET;
        } else {
            $request = $_POST;
        }

        $this->initRequestParser($request);
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
