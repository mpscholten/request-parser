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
        $exception = $this->factory->createNotFoundException('id');

        $this->assertInstanceOf(NotFoundException::class, $exception);
        $this->assertEquals('Parameter "id" not found', $exception->getMessage());
    }

    public function testCreateInvalidValueException()
    {
        $exception = $this->factory->createInvalidValueException('id', 'invalidinteger', 'an integer');

        $this->assertInstanceOf(NotFoundException::class, $exception);
        $this->assertEquals('Invalid value for parameter "id". Expected an integer, but got "invalidinteger"', $exception->getMessage());
    }
}
