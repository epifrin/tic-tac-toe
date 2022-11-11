<?php

namespace App\Tests\Unit;

use App\Domain\Board\Board;
use App\Domain\Board\CellPlace;
use App\Domain\Cell\CellType;
use App\Domain\Computer\Strategy\RandomStrategy;
use PHPUnit\Framework\TestCase;

class RandomStrategyTest extends TestCase
{
    public function testRandomStrategy()
    {
        $board = new Board();
        $board->setCell(CellType::X, new CellPlace(5));
        $board->setCell(CellType::O, new CellPlace(1));
        $board->setCell(CellType::X, new CellPlace(9));

        $randomStrategy = new RandomStrategy();
        $cellPlace = $randomStrategy->getComputerMove($board);
        $this->assertContains($cellPlace->value(), [2, 3, 4, 6, 7, 8]);
    }
}
