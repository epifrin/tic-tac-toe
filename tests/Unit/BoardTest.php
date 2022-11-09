<?php

namespace App\Tests\Unit;

use App\Domain\Board\Board;
use App\Domain\Cell\CellType;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function testSetCellCorrect(): void
    {
        $board = new Board();

        $place = 5;
        $board->setCell(CellType::X, $place);

        $this->assertEquals($board->getCell($place)->getType(), CellType::X);
    }

    public function testSetAlreadyTakenCell(): void
    {
        $this->expectExceptionMessage('This place is already taken');

        $board = new Board();
        $place = 1;
        $board->setCell(CellType::O, $place);

        $board->setCell(CellType::O, $place);
    }

    public function testCountMoves(): void
    {
        $board = new Board();

        $board->setCell(CellType::X, 5);
        $this->assertEquals($board->countMoves(), 1);

        $board->setCell(CellType::O, 1);
        $this->assertEquals($board->countMoves(), 2);

        $board->setCell(CellType::X, 3);
        $this->assertEquals($board->countMoves(), 3);
    }
}
