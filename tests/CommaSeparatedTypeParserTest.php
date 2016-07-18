<?php

namespace Test\Common\Foundation\RequestSpec;

use MPScholten\RequestParser\CommaSeparatedTypeParser;

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
        $result = (new CommaSeparatedTypeParser($this->createExceptionFactory(), 'intArr', '1,2,3,4'))->int();
        $this->assertEquals($expected, $result);
    }

    public function testCsvWithFloat()
    {
        $expected = [1.1, 2.99, 3.4, 4.13];
        $result = (new CommaSeparatedTypeParser($this->createExceptionFactory(), 'intArr', '1.1,2.99,3.4,4.13'))->float();
        $this->assertEquals($expected, $result);
    }

    public function testCsvWithString()
    {
        $expected = ['apples', 'oranges', 'tomatoes'];
        $result = (new CommaSeparatedTypeParser($this->createExceptionFactory(), 'intArr', 'apples,oranges,tomatoes'))->string();
        $this->assertEquals($expected, $result);
    }

    public function testCsvWithDateTime()
    {
        $expected = [
            new \DateTime('2016-01-01'),
            new \DateTime('2016-01-02'),
            new \DateTime('2016-01-03')
        ];
        $result = (new CommaSeparatedTypeParser($this->createExceptionFactory(), 'intArr', '2016-01-01,2016-01-02,2016-01-03'))->dateTime();
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
        $result = (new CommaSeparatedTypeParser($this->createExceptionFactory(), 'intArr', $value))->json();
        $this->assertEquals($expected, $result);
    }

    public function testCsvWithBoolean()
    {
        $expected = [false, true, true];
        $result = (new CommaSeparatedTypeParser($this->createExceptionFactory(), 'intArr', 'false,true,true'))->boolean();
        $this->assertEquals($expected, $result);
    }

    public function testCsvWithYesNoBoolean()
    {
        $expected = [true, false, true];
        $result = (new CommaSeparatedTypeParser($this->createExceptionFactory(), 'intArr', 'Y,N,Y'))->yesNoBoolean();
        $this->assertEquals($expected, $result);
    }
}
