<?php

use MPScholten\RequestParser\AbstractValueParser;
use MPScholten\RequestParser\Config;
use MPScholten\RequestParser\DateTimeParser;
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
use MPScholten\RequestParser\TrimParser;

class ParserSpecTest extends \PHPUnit_Framework_TestCase
{
    public function specWithoutValueAndDefaultValueProvider()
    {
        return [
            // [spec, default-value]
            [new IntParser(new Config(), 'id', null), 1],
            [new FloatParser(new Config(), 'ratio', null), 0.91],
            [new StringParser(new Config(), 'name', null), 'default value'],
            [new EmailParser(new Config(), 'emailAddress', null), 'john@doe.com'],
            [new UrlParser(new Config(), 'referrer', null), 'https://www.quintly.com/'],
            [new OneOfParser(new Config(), 'type', null, ['a', 'b']), 'a'],
            [new DateTimeParser(new Config(), 'createdAt', null), new \DateTime('2015-01-01')],
            [new JsonParser(new Config(), 'config', null), ['value' => true]],
            [new YesNoBooleanParser(new Config(), 'isAwesome', null), true],
            [new BooleanParser(new Config(), 'isNice', null), true]
        ];
    }

    public function specWithValueAndDefaultValue()
    {
        return [
            // [spec, default-value, real-value]
            [new IntParser(new Config(), 'id', 1337), 1, 1337],
            [new FloatParser(new Config(), 'ratio', 0.91), 1.0, 0.91],
            [new YesNoBooleanParser(new Config(), 'isAwesome', 'yes'), true, true],
            [new BooleanParser(new Config(), 'isAwesome', 'true'), true, true],
            [new StringParser(new Config(), 'name', 'quintly'), '', 'quintly'],
            [new UrlParser(new Config(), 'referrer', 'https://www.quintly.com/'), 'https://www.quintly.com/blog/', 'https://www.quintly.com/'],
            [new EmailParser(new Config(), 'emailAddress', 'john@doe.com'), '', 'john@doe.com'],
            [new TrimParser(new Config(), 'emailAddress', '  john@doe.com  ', TrimParser::TRIM), '', 'john@doe.com'],
            [new TrimParser(new Config(), 'emailAddress', '  john@doe.com', TrimParser::LEFT_TRIM), '', 'john@doe.com'],
            [new TrimParser(new Config(), 'emailAddress', 'john@doe.com  ', TrimParser::RIGHT_TRIM), '', 'john@doe.com'],
            [new OneOfParser(new Config(), 'type', 'a', ['a', 'b']), 'b', 'a'],
            [new DateTimeParser(new Config(), 'createdAt', '2015-02-02'), new \DateTime('2015-01-01'), new \DateTime('2015-02-02')],
            [new JsonParser(new Config(), 'config', '{"value":false}'), ['value' => true], ['value' => false]]
        ];
    }

    public function specWithInvalidValueAndDefaultValue()
    {
        return [
            [new IntParser(new Config(), 'id', 'string instead of an int'), 1],
            [new FloatParser(new Config(), 'ration', 'string instead of a float'), 0.91],
            [new YesNoBooleanParser(new Config(), 'isAwesome', 'invalid'), false],
            [new BooleanParser(new Config(), 'isAwesome', 'invalid'), false],
            [new EmailParser(new Config(), 'emailAddress', 'invalid_email'), 'john@doe.com'],
            [new UrlParser(new Config(), 'referrer', 'https:://www.invalid.url/^'), 'https://www.quintly.com/'],
            // StringParser has no invalid data types
            [new OneOfParser(new Config(), 'type', 'x', ['a', 'b']), 'a'],
            [new DateTimeParser(new Config(), 'createdAt', ''), new \DateTime('2015-01-01')],
            [new JsonParser(new Config(), 'config', 'invalid json{'), ['value' => true]]
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
        $parser = new StringParser(new Config(), 'name', '');
        $this->assertEquals('default', $parser->defaultsToIfEmpty('default'));

        $parser = new StringParser(new Config(), 'name', 'test');
        $this->assertEquals('test', $parser->defaultsToIfEmpty('default'));
    }

    public function testBetweenValidatorWithValidValues()
    {
        $parser = new IntParser(new Config(), 'groupId', 1);
        $parser->between(1, 6);
        $this->assertEquals(1, $parser->required());
        $parser = new IntParser(new Config(), 'groupId', 6);
        $parser->between(1, 6);
        $this->assertEquals(6, $parser->required());

        $parser = new FloatParser(new Config(), 'precipitation', 60.99);
        $parser->between(60.99, 101.12);
        $this->assertEquals(60.99, $parser->required());
        $parser = new FloatParser(new Config(), 'precipitation', 101.12);
        $parser->between(60.99, 101.12);
        $this->assertEquals(101.12, $parser->required());
    }

    public function testIntBetweenValidatorWithValuesOutOfRange()
    {
        $this->setExpectedException(InvalidValueException::class, 'Invalid value for parameter "groupId". Expected an integer between 1 and 6, but got "7"');
        $parser = new IntParser(new Config(), 'groupId', 7);
        $groupId = $parser->between(1, 6)->required();
    }

    public function testFloatBetweenValidatorWithValuesOutOfRange()
    {
        $this->setExpectedException(InvalidValueException::class, 'Invalid value for parameter "precipitation". Expected a float between 60.99 and 101.12, but got "101.13"');
        $parser = new FloatParser(new Config(), 'precipitation', 101.13);
        $precipitation = $parser->between(60.99, 101.12)->required();
    }
}
