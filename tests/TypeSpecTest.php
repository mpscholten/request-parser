<?php

namespace Test\Common\Foundation\RequestSpec;

use MPScholten\RequestParser\CommaSeparatedBooleanParser;
use MPScholten\RequestParser\CommaSeparatedDateTimeParser;
use MPScholten\RequestParser\CommaSeparatedFloatParser;
use MPScholten\RequestParser\CommaSeparatedIntParser;
use MPScholten\RequestParser\CommaSeparatedJsonParser;
use MPScholten\RequestParser\CommaSeparatedStringParser;
use MPScholten\RequestParser\CommaSeparatedYesNoBooleanParser;
use MPScholten\RequestParser\DateTimeParser;
use MPScholten\RequestParser\EmailParser;
use MPScholten\RequestParser\IntParser;
use MPScholten\RequestParser\FloatParser;
use MPScholten\RequestParser\YesNoBooleanParser;
use MPScholten\RequestParser\BooleanParser;
use MPScholten\RequestParser\JsonParser;
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

    public function testEmail()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'emailAddress', 'john@doe.com');
        $this->assertInstanceOf(EmailParser::class, $spec->email());
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

    // CSV type spec tests:
    public function testCommaSeparatedInt()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'hundreds', '100,200,300');
        $this->assertInstanceOf(CommaSeparatedIntParser::class, $spec->commaSeparated()->int());
    }

    public function testCommaSeparatedFloat()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'precipitation', '0.91,1.22,4.50');
        $this->assertInstanceOf(CommaSeparatedFloatParser::class, $spec->commaSeparated()->float());
    }

    public function testCommaSeparatedString()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'tags', 'quintly,social,media,analytics');
        $this->assertInstanceOf(CommaSeparatedStringParser::class, $spec->commaSeparated()->string());
    }

    public function testCommaSeparatedDateTime()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'eventsAt', '2016-01-01,2016-01-02');
        $this->assertInstanceOf(CommaSeparatedDateTimeParser::class, $spec->commaSeparated()->dateTime());
    }

    public function testCommaSeparatedJson()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'payload', '{"a":5},{"a":6}');
        $this->assertInstanceOf(CommaSeparatedJsonParser::class, $spec->commaSeparated()->json());
    }

    public function testCommaSeparatedYesNoBoolean()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'answers', 'yes,no,yes');
        $this->assertInstanceOf(CommaSeparatedYesNoBooleanParser::class, $spec->commaSeparated()->yesNoBoolean());
    }

    public function testCommaSeparatedBoolean()
    {
        $spec = new TypeParser($this->createExceptionFactory(), 'answers', 'true,false,true');
        $this->assertInstanceOf(CommaSeparatedBooleanParser::class, $spec->commaSeparated()->boolean());
    }
}
