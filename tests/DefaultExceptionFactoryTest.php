<?php

use MPScholten\RequestParser\ExceptionFactory;
use MPScholten\RequestParser\NotFoundException;

class ExceptionFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ExceptionFactory
     */
    private $factory;

    protected function setUp()
    {
        $this->factory = new ExceptionFactory();
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
