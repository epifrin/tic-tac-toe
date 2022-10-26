<?php

namespace App\Domain\GameResult;

use App\Domain\Board\Board;
use App\Domain\Cell\CellType;

class GameResultChecker
{
    private const MIN_MOVES_TO_HAVE_RESULT = 5;
    private const MAX_MOVES = 9;

    /**
     * possible lines with places
     * 1 | 2 | 3
     * 4 | 5 | 6
     * 7 | 8 | 9
     */
    private const ALL_POSSIBLE_LINES = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9],
        [1, 4, 7],
        [2, 5, 8],
        [3, 6, 9],
        [1, 5, 9],
        [3, 5, 7]
    ];

    public function check(Board $board): GameResult
    {
        if ($board->countMoves() < self::MIN_MOVES_TO_HAVE_RESULT) {
            return new GameResult();
        }

        $gameResult = $this->checkWinner($board);
        if ($gameResult->hasWinner()) {
            return $gameResult;
        }

        if ($board->countMoves() === self::MAX_MOVES) {
            return (new GameResult())->setDraw();
        }

        return new GameResult();
    }

    private function checkWinner(Board $board): GameResult
    {
        foreach ([CellType::X, CellType::O] as $cellType) {
            foreach (self::ALL_POSSIBLE_LINES as $line) {
                $countSameCell = 0;
                foreach ($line as $place) {
                    if ($board->getCell($place)->getType() === $cellType) {
                        $countSameCell++;
                    }
                    if ($countSameCell === 3) {
                        return (new GameResult())->setWinner($cellType);
                    }
                }
            }
        }

        return new GameResult();
    }
}
