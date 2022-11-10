<?php

namespace App\Domain\GameResult;

use App\Domain\Board\Board;
use App\Domain\Board\CellPlace;
use App\Domain\Cell\CellType;

class GameResultChecker
{
    private const MIN_MOVES_TO_HAVE_RESULT = 5;
    private const MAX_MOVES = 9;

    public function check(Board $board): GameResult
    {
        if ($board->countMoves() < self::MIN_MOVES_TO_HAVE_RESULT) {
            return new GameResult();
        }

        $gameResult = $this->checkWinner($board);
        if ($gameResult->hasWinner()) {
            return $gameResult;
        }

        return $this->checkDraw($board);
    }

    private function checkWinner(Board $board): GameResult
    {
        foreach ([CellType::X, CellType::O] as $cellType) {
            foreach (Board::ALL_POSSIBLE_WIN_LINES as $line) {
                $countSameCell = 0;
                foreach ($line as $place) {
                    if ($board->getCell(new CellPlace($place))->getType() === $cellType) {
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

    private function checkDraw(Board $board): GameResult
    {
        if ($board->countMoves() === self::MAX_MOVES) {
            return (new GameResult())->setDraw();
        }

        $lines = Board::ALL_POSSIBLE_WIN_LINES;
        foreach ($lines as $key => $line) {
            if (
                $board->countCellTypeInLine(CellType::X, $line) > 0 &&
                $board->countCellTypeInLine(CellType::O, $line) > 0
            ) {
                unset($lines[$key]);
            }
        }
        if (empty($lines)) {
            return (new GameResult())->setDraw();
        }

        return new GameResult();
    }
}
