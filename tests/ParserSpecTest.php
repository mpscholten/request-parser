<?php

use MPScholten\RequestParser\AbstractValueParser;
use MPScholten\RequestParser\DateTimeParser;
use MPScholten\RequestParser\IntParser;
use MPScholten\RequestParser\FloatParser;
use MPScholten\RequestParser\YesNoBooleanParser;
use MPScholten\RequestParser\JsonParser;
use MPScholten\RequestParser\NotFoundException;
use MPScholten\RequestParser\OneOfParser;
use MPScholten\RequestParser\StringParser;

class ParserSpecTest extends \PHPUnit_Framework_TestCase
{
    private function createExceptionFactory()
    {
        return function() {
            throw new NotFoundException();
        };
    }

    public function specWithoutValueAndDefaultValueProvider()
    {
        return [
            // [spec, default-value]
            [new IntParser($this->createExceptionFactory(), 'id', null), 1],
            [new FloatParser($this->createExceptionFactory(), 'ratio', null), 0.91],
            [new StringParser($this->createExceptionFactory(), 'name', null), 'default value'],
            [new OneOfParser($this->createExceptionFactory(), 'type', null, ['a', 'b']), 'a'],
            [new DateTimeParser($this->createExceptionFactory(), 'createdAt', null), new \DateTime('2015-01-01')],
            [new JsonParser($this->createExceptionFactory(), 'config', null), ['value' => true]],
            [new YesNoBooleanParser($this->createExceptionFactory(), 'YES', null), true],
            [new YesNoBooleanParser($this->createExceptionFactory(), 'Y', null), true],
            [new YesNoBooleanParser($this->createExceptionFactory(), 'NO', null), false],
            [new YesNoBooleanParser($this->createExceptionFactory(), 'N', null), false]
        ];
    }

    public function specWithValueAndDefaultValue()
    {
        return [
            // [spec, default-value, real-value]
            [new IntParser($this->createExceptionFactory(), 'id', 1337), 1, 1337],
            [new FloatParser($this->createExceptionFactory(), 'ratio', 0.91), 1.0, 0.91],
            [new YesNoBooleanParser($this->createExceptionFactory(), 'isAwesome', true), false, true],
            [new StringParser($this->createExceptionFactory(), 'name', 'quintly'), '', 'quintly'],
            [new OneOfParser($this->createExceptionFactory(), 'type', 'a', ['a', 'b']), 'b', 'a'],
            [new DateTimeParser($this->createExceptionFactory(), 'createdAt', '2015-02-02'), new \DateTime('2015-01-01'), new \DateTime('2015-02-02')],
            [new JsonParser($this->createExceptionFactory(), 'config', '{"value":false}'), ['value' => true], ['value' => false]]
        ];
    }

    public function specWithInvalidValueAndDefaultValue()
    {
        return [
            [new IntParser($this->createExceptionFactory(), 'id', 'string instead of an int'), 1],
            [new FloatParser($this->createExceptionFactory(), 'ration', 'string instead of an float'), 0.91],
            [new YesNoBooleanParser($this->createExceptionFactory(), 'isAwesome', 'absolutely'), false],
            // StringParser has no invalid data types
            [new OneOfParser($this->createExceptionFactory(), 'type', 'x', ['a', 'b']), 'a'],
            [new DateTimeParser($this->createExceptionFactory(), 'createdAt', ''), new \DateTime('2015-01-01')],
            [new JsonParser($this->createExceptionFactory(), 'config', 'invalid json{'), ['value' => true]]
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
     * @dataProvider specWithInvalidValueAndDefaultValue
     */
    public function testRequiredThrowsExceptionOnInvalidValue(AbstractValueParser $spec)
    {
        $this->setExpectedException(NotFoundException::class);
        $spec->required();
    }
}
