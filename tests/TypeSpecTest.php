<?php

namespace Test\Common\Foundation\RequestSpec;

use MPScholten\RequestParser\CommaSeparatedBooleanParser;
use MPScholten\RequestParser\CommaSeparatedDateTimeParser;
use MPScholten\RequestParser\CommaSeparatedFloatParser;
use MPScholten\RequestParser\CommaSeparatedIntParser;
use MPScholten\RequestParser\CommaSeparatedJsonParser;
use MPScholten\RequestParser\CommaSeparatedStringParser;
use MPScholten\RequestParser\CommaSeparatedYesNoBooleanParser;
use MPScholten\RequestParser\Config;
use MPScholten\RequestParser\DateTimeParser;
use MPScholten\RequestParser\ExceptionMessageFactory;
use MPScholten\RequestParser\EmailParser;
use MPScholten\RequestParser\ExceptionFactory;
use MPScholten\RequestParser\IntParser;
use MPScholten\RequestParser\FloatParser;
use MPScholten\RequestParser\TrimParser;
use MPScholten\RequestParser\UrlParser;
use MPScholten\RequestParser\YesNoBooleanParser;
use MPScholten\RequestParser\BooleanParser;
use MPScholten\RequestParser\JsonParser;
use MPScholten\RequestParser\NotFoundException;
use MPScholten\RequestParser\OneOfParser;
use MPScholten\RequestParser\StringParser;
use MPScholten\RequestParser\TypeParser;

class TypeSpecTest extends \PHPUnit_Framework_TestCase
{
    public function testInt()
    {
        $spec = new TypeParser(new Config(), 'id', '100');
        $this->assertInstanceOf(IntParser::class, $spec->int());
    }

    public function testFloat()
    {
        $spec = new TypeParser(new Config(), 'ratio', '0.91');
        $this->assertInstanceOf(FloatParser::class, $spec->float());
    }

    public function testString()
    {
        $spec = new TypeParser(new Config(), 'name', 'quintly');
        $this->assertInstanceOf(StringParser::class, $spec->string());
    }

    public function testUrl()
    {
        $spec = new TypeParser(new Config(), 'referrer', 'https://www.quintly.com/');
        $this->assertInstanceOf(UrlParser::class, $spec->string()->url());
    }

    public function testEmail()
    {
        $spec = new TypeParser(new Config(), 'emailAddress', 'john@doe.com');
        $this->assertInstanceOf(EmailParser::class, $spec->string()->email());
    }

    public function testTrim()
    {
        $spec = new TypeParser(new Config(), 'emailAddress', '   john@doe.com   ');
        $this->assertInstanceOf(TrimParser::class, $spec->string()->trim());
    }

    public function testOneOf()
    {
        $spec = new TypeParser(new Config(), 'type', 'b');
        $this->assertInstanceOf(OneOfParser::class, $spec->oneOf(['a', 'b']));
    }

    public function testDateTime()
    {
        $spec = new TypeParser(new Config(), 'createdAt', '01-01-2016');
        $this->assertInstanceOf(DateTimeParser::class, $spec->dateTime());
    }

    public function testJson()
    {
        $spec = new TypeParser(new Config(), 'payload', '{}');
        $this->assertInstanceOf(JsonParser::class, $spec->json());
    }

    public function testYesNoBoolean()
    {
        $spec = new TypeParser(new Config(), 'isAwesome', 'yes');
        $this->assertInstanceOf(YesNoBooleanParser::class, $spec->yesNoBoolean());
    }

    public function testBoolean()
    {
        $spec = new TypeParser(new Config(), 'isAwesome', 'true');
        $this->assertInstanceOf(BooleanParser::class, $spec->boolean());
    }

    // CSV type spec tests:
    public function testCommaSeparatedInt()
    {
        $spec = new TypeParser(new Config(), 'hundreds', '100,200,300');
        $this->assertInstanceOf(CommaSeparatedIntParser::class, $spec->commaSeparated()->int());
    }

    public function testCommaSeparatedFloat()
    {
        $spec = new TypeParser(new Config(), 'precipitation', '0.91,1.22,4.50');
        $this->assertInstanceOf(CommaSeparatedFloatParser::class, $spec->commaSeparated()->float());
    }

    public function testCommaSeparatedString()
    {
        $spec = new TypeParser(new Config(), 'tags', 'quintly,social,media,analytics');
        $this->assertInstanceOf(CommaSeparatedStringParser::class, $spec->commaSeparated()->string());
    }

    public function testCommaSeparatedDateTime()
    {
        $spec = new TypeParser(new Config(), 'eventsAt', '2016-01-01,2016-01-02');
        $this->assertInstanceOf(CommaSeparatedDateTimeParser::class, $spec->commaSeparated()->dateTime());
    }

    public function testCommaSeparatedJson()
    {
        $spec = new TypeParser(new Config(), 'payload', '{"a":5},{"a":6}');
        $this->assertInstanceOf(CommaSeparatedJsonParser::class, $spec->commaSeparated()->json());
    }

    public function testCommaSeparatedYesNoBoolean()
    {
        $spec = new TypeParser(new Config(), 'answers', 'yes,no,yes');
        $this->assertInstanceOf(CommaSeparatedYesNoBooleanParser::class, $spec->commaSeparated()->yesNoBoolean());
    }

    public function testCommaSeparatedBoolean()
    {
        $spec = new TypeParser(new Config(), 'answers', 'true,false,true');
        $this->assertInstanceOf(CommaSeparatedBooleanParser::class, $spec->commaSeparated()->boolean());
    }
}
