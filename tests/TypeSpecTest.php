<?php

namespace Test\Common\Foundation\RequestSpec;

use MPScholten\RequestParser\DateTimeParser;
use MPScholten\RequestParser\IntParser;
use MPScholten\RequestParser\FloatParser;
use MPScholten\RequestParser\YesNoBooleanParser;
use MPScholten\RequestParser\BooleanParser;
use MPScholten\RequestParser\JsonParser;
use MPScholten\RequestParser\NotFoundException;
use MPScholten\RequestParser\OneOfParser;
use MPScholten\RequestParser\StringParser;
use MPScholten\RequestParser\TypeParser;
use MPScholten\RequestParser\CommaSeparatedStringParser;

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

    public function testFloat()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'ratio', '0.91');
        $this->assertInstanceOf(FloatParser::class, $spec->float());
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

    public function testDateTime()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'createdAt', '01-01-2016');
        $this->assertInstanceOf(DateTimeParser::class, $spec->dateTime());
    }

    public function testJson()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'payload', '{}');
        $this->assertInstanceOf(JsonParser::class, $spec->json());
    }

    public function testYesNoBoolean()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'isAwesome', 'yes');
        $this->assertInstanceOf(YesNoBooleanParser::class, $spec->yesNoBoolean());
    }

    public function testBoolean()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'isAwesome', 'true');
        $this->assertInstanceOf(BooleanParser::class, $spec->boolean());
    }
}
