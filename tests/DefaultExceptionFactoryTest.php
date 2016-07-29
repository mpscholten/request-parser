<?php

use MPScholten\RequestParser\DefaultExceptionFactory;
use MPScholten\RequestParser\NotFoundException;

class DefaultExceptionFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DefaultExceptionFactory
     */
    private $factory;

    protected function setUp()
    {
        $this->factory = new DefaultExceptionFactory();
    }

    public function testCreateNotFoundException()
    {
        $exception = $this->factory->createNotFoundException('message');

        $this->assertInstanceOf(NotFoundException::class, $exception);
        $this->assertEquals('message', $exception->getMessage());
    }

    public function testCreateInvalidValueException()
    {
        $exception = $this->factory->createInvalidValueException('message');

        $this->assertInstanceOf(NotFoundException::class, $exception);
        $this->assertEquals('message', $exception->getMessage());
    }
}
