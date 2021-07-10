<?php

use PHPUnit\Framework\TestCase;

class SayHelloArgumentTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        $this->assertEquals($expected, sayHelloArgument($input));
    }


    public function positiveDataProvider()
    {
        return [
            ['123456', "Hello 123456"],
            ['dariy', "Hello dariy"],
            ['qwerty', "Hello qwerty"],
            ['den', "Hello den"],
        ];
    }
}


