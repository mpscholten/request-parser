<?php

use MPScholten\RequestParser\ExceptionMessageFactory;

class ExceptionMessageFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ExceptionMessageFactory
     */
    private $factory;

    protected function setUp()
    {
        $this->factory = new ExceptionMessageFactory();
    }

    public function testCreateNotFoundException()
    {
        $message = $this->factory->createNotFoundMessage('id');

        $this->assertEquals('Parameter "id" not found', $message);
    }

    public function testCreateInvalidValueException()
    {
        $message = $this->factory->createInvalidValueMessage('id', 'invalidinteger', 'an integer');

        $this->assertEquals('Invalid value for parameter "id". Expected an integer, but got "invalidinteger"', $message);
    }

}
