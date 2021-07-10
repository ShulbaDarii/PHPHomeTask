<?php

use PHPUnit\Framework\TestCase;

class SayHelloArgumentWrapperTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        $this->assertEquals($expected, sayHelloArgumentWrapper($input));
    }
    public function testNegative()
    {
        $this->expectException(InvalidArgumentException::class);

        sayHelloArgumentWrapper(['123456', "Hello 123456"]);
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


