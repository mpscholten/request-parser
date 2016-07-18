<?php

use MPScholten\RequestParser\AbstractValueParser;
use MPScholten\RequestParser\DateTimeParser;
use MPScholten\RequestParser\IntParser;
use MPScholten\RequestParser\FloatParser;
use MPScholten\RequestParser\YesNoBooleanParser;
use MPScholten\RequestParser\BooleanParser;
use MPScholten\RequestParser\JsonParser;
use MPScholten\RequestParser\NotFoundException;
use MPScholten\RequestParser\OneOfParser;
use MPScholten\RequestParser\StringParser;
use MPScholten\RequestParser\CommaSeparatedParser;

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
            [new YesNoBooleanParser($this->createExceptionFactory(), 'isAwesome', null), true],
            [new BooleanParser($this->createExceptionFactory(), 'isNice', null), true],
            // [spec, default-value] with comma-separated data types:
            [new CommaSeparatedParser($this->createExceptionFactory(), 'groups', null, 'INT'), [1, 2, 3, 4]],
            [new CommaSeparatedParser($this->createExceptionFactory(), 'fruits', null, 'STRING'), ['apple', 'banana', 'orange', 'pear']],
            [new CommaSeparatedParser($this->createExceptionFactory(), 'precipitation', null, 'FLOAT'), [0.91, 8.15, 4.101]],
            [new CommaSeparatedParser($this->createExceptionFactory(), 'trueFalseAnswers', null, 'BOOLEAN'), [true, false, true]],
            [new CommaSeparatedParser($this->createExceptionFactory(), 'yesNoAnswers', null, 'YES_NO_BOOLEAN'), [true, true, false]],
            [new CommaSeparatedParser($this->createExceptionFactory(), 'dateSamples', null, 'DATE_TIME'), [
                new \DateTime('2016-01-01'),
                new \DateTime('2016-01-02'),
                new \DateTime('2016-01-03')]
            ],
            [new CommaSeparatedParser($this->createExceptionFactory(), 'events', null, 'JSON'), [
                ['event' => 'page_view', 'deviceTimestamp' => '2016-01-01 08:10:00.151', 'url' => 'https://www.domain.com/product/smart-phone/'],
                ['event' => 'add_to_cart', 'deviceTimestamp' => '2016-01-01 08:10:10.982', 'url' => 'https://www.domain.com/product/smart-phone/'],
                ['event' => 'page_view', 'deviceTimestamp' => '2016-01-01 08:10:11.101', 'url' => 'https://www.domain.com/shopping-cart/']
            ]]
        ];
    }

    public function specWithValueAndDefaultValue()
    {
        return [
            // [spec, default-value, real-value]
            [new IntParser($this->createExceptionFactory(), 'id', 1337), 1, 1337],
            [new FloatParser($this->createExceptionFactory(), 'ratio', 0.91), 1.0, 0.91],
            [new YesNoBooleanParser($this->createExceptionFactory(), 'isAwesome', 'yes'), true, true],
            [new BooleanParser($this->createExceptionFactory(), 'isAwesome', 'true'), true, true],
            [new StringParser($this->createExceptionFactory(), 'name', 'quintly'), '', 'quintly'],
            [new OneOfParser($this->createExceptionFactory(), 'type', 'a', ['a', 'b']), 'b', 'a'],
            [new DateTimeParser($this->createExceptionFactory(), 'createdAt', '2015-02-02'), new \DateTime('2015-01-01'), new \DateTime('2015-02-02')],
            [new JsonParser($this->createExceptionFactory(), 'config', '{"value":false}'), ['value' => true], ['value' => false]],
            [new CommaSeparatedParser($this->createExceptionFactory(), 'groups', '1,2,3,4', 'INT'), ['5', '6', '7', '8'], ['1', '2', '3', '4']],
            [new CommaSeparatedParser($this->createExceptionFactory(), 'fruits', 'cherry,apricot', 'STRING'),
                ['apple', 'banana', 'orange', 'pear'],
                ['cherry', 'apricot']
            ],
            [new CommaSeparatedParser($this->createExceptionFactory(), 'precipitation', '0.91,8.15,4.101', 'FLOAT'), [91.0, 15.8], [0.91, 8.15, 4.101]],
            [new CommaSeparatedParser($this->createExceptionFactory(), 'trueFalseAnswers', 'true,false,true', 'BOOLEAN'), [true, true, false], [true, false, true]],
            [new CommaSeparatedParser($this->createExceptionFactory(), 'yesNoAnswers', 'yes,yes,no', 'YES_NO_BOOLEAN'), [true, false, true], [true, true, false]],
            [new CommaSeparatedParser($this->createExceptionFactory(), 'dateSamples', '2016-01-01,2016-01-02,2016-01-03', 'DATE_TIME'),
                [
                    new \DateTime('2010-12-24')
                ],
                [
                    new \DateTime('2016-01-01'),
                    new \DateTime('2016-01-02'),
                    new \DateTime('2016-01-03')
                ]
            ],
            [new CommaSeparatedParser($this->createExceptionFactory(), 'events', '{"event":"page_view","deviceTimestamp":"2016-01-01 08:10:00.151","url":"https://www.domain.com/"}', 'JSON'),
                [
                    ['event' => 'page_view', 'deviceTimestamp' => '2016-01-01 08:10:00.151', 'url' => 'https://www.domain.com/product/smart-phone/'],
                    ['event' => 'add_to_cart', 'deviceTimestamp' => '2016-01-01 08:10:10.982', 'url' => 'https://www.domain.com/product/smart-phone/'],
                    ['event' => 'page_view', 'deviceTimestamp' => '2016-01-01 08:10:11.101', 'url' => 'https://www.domain.com/shopping-cart/']
                ],
                [
                    ['event' => 'page_view', 'deviceTimestamp' => '2016-01-01 08:10:00.151', 'url' => 'https://www.domain.com/']
                ]
            ]
        ];
    }

    public function specWithInvalidValueAndDefaultValue()
    {
        return [
            [new IntParser($this->createExceptionFactory(), 'id', 'string instead of an int'), 1],
            [new FloatParser($this->createExceptionFactory(), 'ration', 'string instead of an float'), 0.91],
            [new YesNoBooleanParser($this->createExceptionFactory(), 'isAwesome', null), false],
            [new BooleanParser($this->createExceptionFactory(), 'isAwesome', null), false],
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
    
    public function testStringSpecific()
    {
        $parser = new StringParser($this->createExceptionFactory(), 'name', '');
        $this->assertEquals('default', $parser->defaultsToIfEmpty('default'));
        
        $parser = new StringParser($this->createExceptionFactory(), 'name', 'test');
        $this->assertEquals('test', $parser->defaultsToIfEmpty('default'));
    }
}
