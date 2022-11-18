<?php

namespace App\Tests\Unit;

use App\Domain\Board\Board;
use App\Domain\Computer\Strategy\SmartStrategy;
use App\Domain\GameResult\GameResultChecker;
use App\Domain\GameService;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    public function testGameWhereComputerWin()
    {
        $gameService = new GameService(new SmartStrategy(), new GameResultChecker());
        $gameService->startNewGame();
        $gameService->handleUserMove(1);
        $gameService->makeComputerMove();
        $gameService->handleUserMove(3);
        $gameService->makeComputerMove();
        $gameService->handleUserMove(7);
        $gameResult = $gameService->makeComputerMove();
        $this->assertTrue($gameResult->isGameOver());
        $this->assertTrue($gameResult->isWinnerO());
        $this->assertInstanceOf(Board::class, $gameService->getBoard());
    }
}
