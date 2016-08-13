<?php

abstract class AbstractIntegrationTest extends \PHPUnit_Framework_TestCase
{
    abstract public function controllersProvider();

    /**
     * @dataProvider controllersProvider
     */
    public function testStringAction(AbstractIntegrationTestController $controller)
    {
        $this->assertEquals('Test', $controller->testString());
    }

    /**
     * @dataProvider controllersProvider
     */
    public function testIntAction(AbstractIntegrationTestController $controller)
    {
        $this->assertEquals(1, $controller->testInt());
    }

    /**
     * @dataProvider controllersProvider
     */
    public function testNotFoundActionThrowsException(AbstractIntegrationTestController $controller)
    {
        $this->setExpectedException(\MPScholten\RequestParser\NotFoundException::class, 'Parameter "notFound" not found');
        $controller->testNotFound();
    }
}

abstract class AbstractIntegrationTestController
{
    private $request;

    public function __construct($request)
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
