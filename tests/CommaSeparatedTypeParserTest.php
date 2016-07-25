<?php

namespace Test\Common\Foundation\RequestSpec;

use MPScholten\RequestParser\CommaSeparatedBooleanParser;
use MPScholten\RequestParser\CommaSeparatedDateTimeParser;
use MPScholten\RequestParser\CommaSeparatedFloatParser;
use MPScholten\RequestParser\CommaSeparatedIntParser;
use MPScholten\RequestParser\CommaSeparatedJsonParser;
use MPScholten\RequestParser\CommaSeparatedStringParser;
use MPScholten\RequestParser\CommaSeparatedYesNoBooleanParser;
use MPScholten\RequestParser\NotFoundException;

class CommaSeparatedTypeParserTest extends \PHPUnit_Framework_TestCase
{
    private function createExceptionFactory()
    {
        return function() {
            throw new NotFoundException();
        };
    }

    public function testCsvWithInt()
    {
        $expected = [1, 2, 3, 4];
        $result = (new CommaSeparatedIntParser($this->createExceptionFactory(), 'intArr', '1,2,3,4'))->required();
        $this->assertEquals($expected, $result);
    }

    public function testCsvWithFloat()
    {
        $expected = [1.1, 2.99, 3.4, 4.13];
        $result = (new CommaSeparatedFloatParser($this->createExceptionFactory(), 'intArr', '1.1,2.99,3.4,4.13'))->required();
        $this->assertEquals($expected, $result);
    }

    public function testCsvWithString()
    {
        $expected = ['apples', 'oranges', 'tomatoes'];
        $result = (new CommaSeparatedStringParser($this->createExceptionFactory(), 'intArr', 'apples,oranges,tomatoes'))->required();
        $this->assertEquals($expected, $result);
    }

    public function testCsvWithDateTime()
    {
        $expected = [
            new \DateTime('2016-01-01'),
            new \DateTime('2016-01-02'),
            new \DateTime('2016-01-03')
        ];
        $result = (new CommaSeparatedDateTimeParser($this->createExceptionFactory(), 'intArr', '2016-01-01,2016-01-02,2016-01-03'))->required();
        $this->assertEquals($expected, $result);
    }

    public function testCsvWithJson()
    {
        $expected = [
            [
                'event' => 'page_view',
                'deviceTimestamp' => '2016-01-01 08:10:00.151',
                'url' => 'https://www.domain.com/'
            ],
            [
                'event' => 'add_to_basket',
                'deviceTimestamp' => '2016-01-02 09:59:00.999',
                'url' => 'https://www.domain.com/'
            ]
        ];
        $value = '{"event":"page_view","deviceTimestamp":"2016-01-01 08:10:00.151","url":"https://www.domain.com/"},{"event":"add_to_basket","deviceTimestamp":"2016-01-02 09:59:00.999","url":"https://www.domain.com/"}';
        $result = (new CommaSeparatedJsonParser($this->createExceptionFactory(), 'intArr', $value))->required();
        $this->assertEquals($expected, $result);
    }

    public function testCsvWithBoolean()
    {
        $expected = [false, true, true];
        $result = (new CommaSeparatedBooleanParser($this->createExceptionFactory(), 'boolArr', 'false,true,true'))->required();
        $this->assertEquals($expected, $result);
    }

    public function testCsvWithYesNoBoolean()
    {
        $expected = [true, false, true];
        $result = (new CommaSeparatedYesNoBooleanParser($this->createExceptionFactory(), 'yesNoBoolArr', 'Y,N,Y'))->required();
        $this->assertEquals($expected, $result);
    }
}
