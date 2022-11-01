<?php

namespace App\Tests\Unit;

use App\Domain\Board\Board;
use App\Domain\Cell\CellType;
use App\Domain\GameResult\GameResultChecker;
use PHPUnit\Framework\TestCase;

class GameResultCheckerTest extends TestCase
{
    public function testLessThanMinMoves(): void
    {
        $board = new Board();
        $board->setCell(CellType::X, 5);
        $board->setCell(CellType::O, 1);
        $board->setCell(CellType::X, 3);
        $gameResult = (new GameResultChecker())->check($board);
        self::assertFalse($gameResult->isGameOver());
        self::assertFalse($gameResult->hasWinner());
    }

    /**
     * @dataProvider winnerXProvider
     * @param array<int, CellType>
     */
    public function testWinnerX(array $boardMoves): void
    {
        $board = new Board();
        foreach ($boardMoves as $place => $cell) {
            $board->setCell($cell, $place);
        }
        $gameResult = (new GameResultChecker())->check($board);
        self::assertTrue($gameResult->isGameOver());
        self::assertTrue($gameResult->hasWinner());
        self::assertTrue($gameResult->isWinnerX());
    }

    public function winnerXProvider(): array
    {
        return [
            '1 2 3' => [[1 => CellType::X, 2 => CellType::X, 3 => CellType::X, 4 => CellType::O, 5 => CellType::O]],
            '4 5 6' => [[4 => CellType::X, 5 => CellType::X, 6 => CellType::X, 1 => CellType::O, 2 => CellType::O]],
            '7 8 9' => [[7 => CellType::X, 8 => CellType::X, 9 => CellType::X, 1 => CellType::O, 2 => CellType::O]],
            '1 4 7' => [[1 => CellType::X, 4 => CellType::X, 7 => CellType::X, 2 => CellType::O, 3 => CellType::O]],
            '2 5 6' => [[2 => CellType::X, 5 => CellType::X, 8 => CellType::X, 1 => CellType::O, 3 => CellType::O]],
            '3 6 9' => [[3 => CellType::X, 6 => CellType::X, 9 => CellType::X, 1 => CellType::O, 2 => CellType::O]],
            '1 5 9' => [[1 => CellType::X, 5 => CellType::X, 9 => CellType::X, 3 => CellType::O, 2 => CellType::O]],
            '3 5 7' => [[3 => CellType::X, 5 => CellType::X, 7 => CellType::X, 8 => CellType::O, 2 => CellType::O]],
        ];
    }

    /**
     * @dataProvider drawMovesProvider
     * @param array<int, CellType>
     */
    public function testDraw(array $boardMoves): void
    {
        $board = new Board();
        foreach ($boardMoves as $place => $cell) {
            $board->setCell($cell, $place);
        }
        $gameResult = (new GameResultChecker())->check($board);
        self::assertTrue($gameResult->isGameOver(), 'game is over');
        self::assertFalse($gameResult->hasWinner(), 'has winner');
        self::assertTrue($gameResult->isDraw(), 'is draw');
    }

    public function drawMovesProvider(): array
    {
        return [
            [
                [
                    1 => CellType::X, 2 => CellType::X, 3 => CellType::O,
                    4 => CellType::O, 5 => CellType::O, 6 => CellType::X,
                    7 => CellType::X, 8 => CellType::X, 9 => CellType::O
                ],
            ],
        ];
    }
}
