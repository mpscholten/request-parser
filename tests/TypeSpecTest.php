<?php

namespace Test\Common\Foundation\RequestSpec;

use MPScholten\RequestParser\IntParser;
use MPScholten\RequestParser\NotFoundException;
use MPScholten\RequestParser\OneOfParser;
use MPScholten\RequestParser\StringParser;
use MPScholten\RequestParser\TypeParser;

class TypeSpecTest extends \PHPUnit_Framework_TestCase
{
    private function createExceptionFactory()
    {
        return function() {
            throw new NotFoundException();
        };
    }


    public function testInt()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'id', '100');
        $this->assertInstanceOf(IntParser::class, $spec->int());
    }

    public function testString()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'name', 'quintly');
        $this->assertInstanceOf(StringParser::class, $spec->string());
    }

    public function testOneOf()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'type', 'b');
        $this->assertInstanceOf(OneOfParser::class, $spec->oneOf(['a', 'b']));
    }
}
