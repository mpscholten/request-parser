<?php

use MPScholten\RequestParser\Config;
use MPScholten\RequestParser\ExceptionFactory;
use MPScholten\RequestParser\ExceptionMessageFactory;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testGetExceptionFactory()
    {
        $config = new Config();
        $this->assertInstanceOf(ExceptionFactory::class, $config->getExceptionFactory());
    }

    public function testGetExceptionMessageFactory()
    {
        $config = new Config();
        $this->assertInstanceOf(ExceptionMessageFactory::class, $config->getExceptionMessageFactory());
    }

    public function testCustomExceptionFactory()
    {
        $customExceptionFactory = new ExceptionFactory(\Exception::class, \Exception::class);

        $config = new Config();
        $config->setExceptionFactory($customExceptionFactory);

        $this->assertSame($customExceptionFactory, $config->getExceptionFactory());
    }

    public function testCustomExceptionMessageFactory()
    {
        $exceptionMessageFactory = new ExceptionMessageFactory();

        $config = new Config();
        $config->setExceptionMessageFactory($exceptionMessageFactory);

        $this->assertSame($exceptionMessageFactory, $config->getExceptionMessageFactory());
    }
}
