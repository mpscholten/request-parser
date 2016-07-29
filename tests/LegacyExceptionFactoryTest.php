<?php

use MPScholten\RequestParser\LegacyExceptionFactory;

class LegacyExceptionFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var LegacyExceptionFactory
     */
    private $factory;

    protected function setUp()
    {
        $closure = function($parameterName) {
            return new \Exception("not found: $parameterName");
        };

        $this->factory = new LegacyExceptionFactory($closure);
    }

    public function testCreateNotFoundException()
    {
        $exception = $this->factory->createNotFoundException('id');

        $this->assertInstanceOf(\Exception::class, $exception);
        $this->assertEquals('not found: id', $exception->getMessage());
    }

    public function testCreateInvalidValueException()
    {
        $exception = $this->factory->createInvalidValueException('id', 'invalidinteger', 'an integer');

        $this->assertInstanceOf(\Exception::class, $exception);
        $this->assertEquals('not found: id', $exception->getMessage());
    }
}
