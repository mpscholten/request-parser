<?php

use MPScholten\RequestParser\AbstractValueParser;
use MPScholten\RequestParser\DateTimeParser;
use MPScholten\RequestParser\DefaultExceptionFactory;
use MPScholten\RequestParser\DefaultMessageFactory;
use MPScholten\RequestParser\IntParser;
use MPScholten\RequestParser\FloatParser;
use MPScholten\RequestParser\InvalidValueException;
use MPScholten\RequestParser\YesNoBooleanParser;
use MPScholten\RequestParser\BooleanParser;
use MPScholten\RequestParser\JsonParser;
use MPScholten\RequestParser\NotFoundException;
use MPScholten\RequestParser\OneOfParser;
use MPScholten\RequestParser\StringParser;
use MPScholten\RequestParser\EmailParser;
use MPScholten\RequestParser\UrlParser;

class ParserSpecTest extends \PHPUnit_Framework_TestCase
{
    private function createExceptionFactory()
    {
        return new DefaultExceptionFactory();
    }

    public function specWithoutValueAndDefaultValueProvider()
    {
        return [
            // [spec, default-value]
            [new IntParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'id', null), 1],
            [new FloatParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'ratio', null), 0.91],
            [new StringParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'name', null), 'default value'],
            [new EmailParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'emailAddress', null), 'john@doe.com'],
            [new UrlParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'referrer', null), 'https://www.quintly.com/'],
            [new OneOfParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'type', null, ['a', 'b']), 'a'],
            [new DateTimeParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'createdAt', null), new \DateTime('2015-01-01')],
            [new JsonParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'config', null), ['value' => true]],
            [new YesNoBooleanParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'isAwesome', null), true],
            [new BooleanParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'isNice', null), true]
        ];
    }

    public function specWithValueAndDefaultValue()
    {
        return [
            // [spec, default-value, real-value]
            [new IntParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'id', 1337), 1, 1337],
            [new FloatParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'ratio', 0.91), 1.0, 0.91],
            [new YesNoBooleanParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'isAwesome', 'yes'), true, true],
            [new BooleanParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'isAwesome', 'true'), true, true],
            [new StringParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'name', 'quintly'), '', 'quintly'],
            [new UrlParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'referrer', 'https://www.quintly.com/'), 'https://www.quintly.com/blog/', 'https://www.quintly.com/'],
            [new EmailParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'emailAddress', 'john@doe.com'), '', 'john@doe.com'],
            [new OneOfParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'type', 'a', ['a', 'b']), 'b', 'a'],
            [new DateTimeParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'createdAt', '2015-02-02'), new \DateTime('2015-01-01'), new \DateTime('2015-02-02')],
            [new JsonParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'config', '{"value":false}'), ['value' => true], ['value' => false]]
        ];
    }

    public function specWithInvalidValueAndDefaultValue()
    {
        return [
            [new IntParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'id', 'string instead of an int'), 1],
            [new FloatParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'ration', 'string instead of an float'), 0.91],
            [new YesNoBooleanParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'isAwesome', 'invalid'), false],
            [new BooleanParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'isAwesome', 'invalid'), false],
            [new EmailParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'emailAddress', 'invalid_email'), 'john@doe.com'],
            [new UrlParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'referrer', 'https:://www.invalid.url/^'), 'https://www.quintly.com/'],
            // StringParser has no invalid data types
            [new OneOfParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'type', 'x', ['a', 'b']), 'a'],
            [new DateTimeParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'createdAt', ''), new \DateTime('2015-01-01')],
            [new JsonParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'config', 'invalid json{'), ['value' => true]]
        ];
    }

    /**
     * @dataProvider specWithoutValueAndDefaultValueProvider
     */
    public function testDefaultsToReturnsDefaultValue(AbstractValueParser $spec, $defaultValue)
    {
        $this->assertEquals($defaultValue, $spec->defaultsTo($defaultValue));
    }

    /**
     * @dataProvider specWithValueAndDefaultValue
     */
    public function testDefaultsToReturnsParameterValue(AbstractValueParser $spec, $defaultValue, $expectedResult)
    {
        $this->assertEquals($expectedResult, $spec->defaultsTo($defaultValue));
    }

    /**
     * @dataProvider specWithInvalidValueAndDefaultValue
     */
    public function testDefaultsToReturnsDefaultValueOnInvalidValue(AbstractValueParser $spec, $defaultValue)
    {
        $this->assertEquals($defaultValue, $spec->defaultsTo($defaultValue));
    }

    /**
     * @dataProvider specWithValueAndDefaultValue
     */
    public function testRequiredReturnsValue(AbstractValueParser $spec, $defaultValue, $value)
    {
        $this->assertEquals($value, $spec->required());
    }

    /**
     * @dataProvider specWithoutValueAndDefaultValueProvider
     */
    public function testRequiredThrowsExceptionOnMissingValue(AbstractValueParser $spec)
    {
        $this->setExpectedException(NotFoundException::class);
        $spec->required();
    }

    /**
     * @dataProvider specWithoutValueAndDefaultValueProvider
     */
    public function testRequiredThrowsExceptionWithCustomMessageOnMissingValue(AbstractValueParser $spec)
    {
        $this->setExpectedException(NotFoundException::class, "custom not found message");
        $spec->required(null, "custom not found message");
    }

    /**
     * @dataProvider specWithInvalidValueAndDefaultValue
     */
    public function testRequiredThrowsExceptionOnInvalidValue(AbstractValueParser $spec)
    {
        $this->setExpectedException(InvalidValueException::class);
        $spec->required();
    }

    #
    /**
     * @dataProvider specWithInvalidValueAndDefaultValue
     */
    public function testRequiredThrowsExceptionWithCustomMessageOnInvalidValue(AbstractValueParser $spec)
    {
        $this->setExpectedException(InvalidValueException::class, "custom invalid value message");
        $spec->required("custom invalid value message");
    }

    public function testStringSpecific()
    {
        $parser = new StringParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'name', '');
        $this->assertEquals('default', $parser->defaultsToIfEmpty('default'));

        $parser = new StringParser($this->createExceptionFactory(), new DefaultMessageFactory(), 'name', 'test');
        $this->assertEquals('test', $parser->defaultsToIfEmpty('default'));
    }
}
