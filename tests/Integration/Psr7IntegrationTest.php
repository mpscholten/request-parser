<?php

class Psr7IntegrationTest extends \PHPUnit_Framework_TestCase
{
    public function controllersProvider()
    {
        $parameters = [
            'string' => 'Test',
            'int' => 1
        ];

        $request = (new Zend\Diactoros\ServerRequest());

        $getRequest = $request
            ->withMethod('GET')
            ->withQueryParams($parameters);

        $postRequest = $request
            ->withMethod('POST')
            ->withParsedBody($parameters);

        return [
            [new Psr7Controller($getRequest)],
            [new Psr7Controller($postRequest)]
        ];
    }

    /**
     * @dataProvider controllersProvider
     */
    public function testStringAction(Psr7Controller $controller)
    {
        $this->assertEquals('Test', $controller->testString());
    }

    /**
     * @dataProvider controllersProvider
     */
    public function testIntAction(Psr7Controller $controller)
    {
        $this->assertEquals(1, $controller->testInt());
    }

    /**
     * @dataProvider  controllersProvider
     */
    public function testNotFoundActionThrowsException(Psr7Controller $controller)
    {
        $this->setExpectedException(\MPScholten\RequestParser\NotFoundException::class, "Parameter notFound not found");
        $controller->testNotFound();
    }
}

class Psr7Controller
{
    use \MPScholten\RequestParser\Psr7\ControllerHelperTrait;

    private $request;

    public function __construct(Psr\Http\Message\ServerRequestInterface $request)
    {
        $this->initRequestParser($request);
        $this->request = $request;
    }

    protected function parameter($name)
    {
        if ($this->request->getMethod() === 'GET') {
            return $this->queryParameter($name);
        } else {
            return $this->bodyParameter($name);
        }
    }

    public function testString()
    {
        return $this->parameter('string')->string()->required();
    }

    public function testInt()
    {
        return $this->parameter('int')->int()->required();
    }

    public function testNotFound()
    {
        return $this->parameter('notFound')->string()->required();
    }
}

