<?php

abstract class AbstractIntegrationTest extends \PHPUnit_Framework_TestCase
{
    abstract public function controllersProvider();

    /**
     * @param AbstractIntegrationTestController $controller
     *
     * @dataProvider controllersProvider
     */
    public function testStringAction(AbstractIntegrationTestController $controller)
    {
        $this->assertEquals('Test', $controller->testString());
        $this->assertEquals('Test', $controller->testString(true));
    }

    /**
     * @param AbstractIntegrationTestController $controller
     *
     * @dataProvider controllersProvider
     */
    public function testIntAction(AbstractIntegrationTestController $controller)
    {
        $this->assertEquals(1, $controller->testInt());
        $this->assertEquals(1, $controller->testInt(true));
    }

    /**
     * @param AbstractIntegrationTestController $controller
     *
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

    protected function parameter($name, $cookie = false)
    {
        if (!$cookie) {
            if ($this->request->getMethod() === 'GET') {
                return $this->queryParameter($name);
            } else {
                return $this->bodyParameter($name);
            }
        } else {
            return $this->cookieParameter($name);
        }
    }

    public function testString($fromCookie = false)
    {
        return $this->parameter('string', $fromCookie)->string()->required();
    }

    public function testInt($fromCookie = false)
    {
        return $this->parameter('int', $fromCookie)->int()->required();
    }

    public function testNotFound()
    {
        return $this->parameter('notFound')->string()->required();
    }
}
