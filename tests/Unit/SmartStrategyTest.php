<?php

namespace App\Tests\Unit;

use App\Domain\Board\Board;
use App\Domain\Board\CellPlace;
use App\Domain\Cell\CellType;
use App\Domain\Computer\Strategy\SmartStrategy;
use PHPUnit\Framework\TestCase;

class SmartStrategyTest extends TestCase
{
    public function testFindWinMove()
    {
        $board = new Board();
        // O | ? | 0
        //   | X |
        // X |   | X
        $board->setCell(CellType::X, new CellPlace(5));
        $board->setCell(CellType::O, new CellPlace(1));
        $board->setCell(CellType::X, new CellPlace(9));
        $board->setCell(CellType::O, new CellPlace(3));
        $board->setCell(CellType::X, new CellPlace(7));

        $smartStrategy = new SmartStrategy();
        $compMove = $smartStrategy->getComputerMove($board);
        $this->assertEquals($compMove, new CellPlace(2));
    }

    public function testDefenceMoveFindLineWithTwoX()
    {
        $board = new Board();
        // O | X | 0
        //   |   |
        // X | ? | X
        $board->setCell(CellType::X, new CellPlace(2));
        $board->setCell(CellType::O, new CellPlace(1));
        $board->setCell(CellType::X, new CellPlace(9));
        $board->setCell(CellType::O, new CellPlace(3));
        $board->setCell(CellType::X, new CellPlace(7));

        $smartStrategy = new SmartStrategy();
        $compMove = $smartStrategy->getComputerMove($board);
        $this->assertEquals($compMove, new CellPlace(8));
    }

    public function testAttackMoveFindLineWithOneO()
    {
        $board = new Board();
        // X |   |
        //   | O | ?
        //   |   | X
        $board->setCell(CellType::X, new CellPlace(1));
        $board->setCell(CellType::O, new CellPlace(5));
        $board->setCell(CellType::X, new CellPlace(9));

        $smartStrategy = new SmartStrategy();
        $compMove = $smartStrategy->getComputerMove($board);
        $this->assertEquals($compMove, new CellPlace(6));
    }

    public function testAttackMoveTakeCenterIfItIsFree()
    {
        $board = new Board();
        // X |   |
        //   | ? |
        //   |   |
        $board->setCell(CellType::X, new CellPlace(1));

        $smartStrategy = new SmartStrategy();
        $compMove = $smartStrategy->getComputerMove($board);
        $this->assertEquals($compMove, new CellPlace(5));
    }

    public function testAttackMoveFindEmptyLine()
    {
        $board = new Board();
        // ? |   |
        //   | X |
        //   |   |
        $board->setCell(CellType::X, new CellPlace(5));

        $smartStrategy = new SmartStrategy();
        $compMove = $smartStrategy->getComputerMove($board);
        $this->assertEquals($compMove, new CellPlace(1));
    }

    public function testAnyMove()
    {
        $board = new Board();
        // O | X | 0
        //   | X | ?
        // X | O | X
        $board->setCell(CellType::X, new CellPlace(5));
        $board->setCell(CellType::O, new CellPlace(1));
        $board->setCell(CellType::X, new CellPlace(7));
        $board->setCell(CellType::O, new CellPlace(3));
        $board->setCell(CellType::X, new CellPlace(2));
        $board->setCell(CellType::O, new CellPlace(8));
        $board->setCell(CellType::X, new CellPlace(9));

        $smartStrategy = new SmartStrategy();
        $compMove = $smartStrategy->getComputerMove($board);
        $this->assertEquals($compMove, new CellPlace(6));
    }

    public function testNoPossibleMoves()
    {
        $this->expectExceptionMessage('No possible moves');
        $this->expectException(\DomainException::class);
        $board = new Board();
        // O | X | 0
        // X | X | O
        // X | O | X
        $board->setCell(CellType::X, new CellPlace(5));
        $board->setCell(CellType::O, new CellPlace(1));
        $board->setCell(CellType::X, new CellPlace(7));
        $board->setCell(CellType::O, new CellPlace(3));
        $board->setCell(CellType::X, new CellPlace(2));
        $board->setCell(CellType::O, new CellPlace(8));
        $board->setCell(CellType::X, new CellPlace(9));
        $board->setCell(CellType::O, new CellPlace(6));
        $board->setCell(CellType::X, new CellPlace(4));

        $smartStrategy = new SmartStrategy();
        $smartStrategy->getComputerMove($board);
    }
}
