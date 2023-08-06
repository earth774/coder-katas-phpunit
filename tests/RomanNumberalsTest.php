<?php

use App\PrimeFactors;
use App\RomanNumberals;
use PHPUnit\Framework\TestCase;

class RomanNumberalsTest extends TestCase
{

    /** 
     * @test
     * @dataProvider checks
     * */
    function it_generates_roman_numberals_for_test_1($number, $numberal)
    {
        $this->assertEquals($numberal, RomanNumberals::generate($number));
    }

    /** 
     * @test
     * */
    function it_generates_roman_numberals_for_less_that_test_1($number, $numberal)
    {
        $this->assertFalse(RomanNumberals::generate(0));
    }

    public function checks()
    {
        return [
            [1, "I"],
            [2, "II"],
            [3, 'III'],
            [4, 'IV'],
            [5, 'V'],
            [6, 'VI'],
            [7, 'VII'],
            [8, 'VIII'],
            [9, 'IX'],
            [10, 'X'],
            [40, 'XL'],
            [50, 'L'],
            [90, 'XC'],
            [100, 'C'],
            [400, 'CD'],
            [500, 'D'],
            [900, 'CM'],
            [1000, 'M'],
            [3999, 'MMMCMXCIX'],
        ];
    }
}
