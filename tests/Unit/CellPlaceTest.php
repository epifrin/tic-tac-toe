<?php

namespace App\Tests\Unit;

use App\Domain\Board\CellPlace;
use PHPUnit\Framework\TestCase;

class CellPlaceTest extends TestCase
{
    /**
     * @dataProvider correctPlaceProvider
     */
    public function testCorrectPlace($place)
    {
        $this->assertEquals((new CellPlace($place))->value(), $place);
    }

    public function correctPlaceProvider()
    {
        return [
            1 => [1],
            2 => [2],
            3 => [3],
            4 => [4],
            5 => [5],
            6 => [6],
            7 => [7],
            8 => [8],
            9 => [9],
        ];
    }

    /**
     * @dataProvider incorrectPlaceProvider
     */
    public function testIncorrectPlace($place)
    {
        $this->expectExceptionMessage('Incorrect place. Please enter correct place');
        new CellPlace($place);
    }

    public function incorrectPlaceProvider()
    {
        return [
            -1 => [-1],
            0 => [0],
            10 => [10],
        ];
    }
}
