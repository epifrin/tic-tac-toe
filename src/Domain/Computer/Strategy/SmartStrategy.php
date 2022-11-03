<?php

namespace App\Domain\Computer\Strategy;

use App\Domain\Board\Board;
use App\Domain\Cell\CellType;

class SmartStrategy implements StrategyInterface
{
    private const CENTER_PLACE = 5;
    private const GOOD_PLACES = [1, 3, 5, 7, 9];

    private Board $board;

    public function getComputerMove(Board $board): int
    {
        $this->board = $board;

        $defenceMove = $this->getDefenceMove();
        if ($defenceMove) {
            return $defenceMove;
        }

        return $this->getAttackMove();
    }

    private function getDefenceMove(): int
    {
        foreach (Board::ALL_POSSIBLE_WIN_LINES as $line) {
            if (
                $this->board->countCellTypeInLine(CellType::X, $line) === 2 &&
                $this->board->countCellTypeInLine(CellType::Empty, $line) === 1
            ) {
                return $this->getEmptyPlaceFromLine($line);
            }
        }
        return 0;
    }

    private function getAttackMove(): int
    {
        $nextMove = $this->findWinMove();
        if ($nextMove) {
            return $nextMove;
        }

        $nextMove = $this->findLineWithOneO();
        if ($nextMove) {
            return $nextMove;
        }

        $nextMove = $this->takeCenterIfFree();
        if ($nextMove) {
            return $nextMove;
        }

        $nextMove = $this->findEmptyLine();
        if ($nextMove) {
            return $nextMove;
        }

        return $this->anyMove();
    }

    private function findWinMove(): int
    {
        foreach (Board::ALL_POSSIBLE_WIN_LINES as $line) {
            if (
                $this->board->countCellTypeInLine(CellType::Empty, $line) === 1 &&
                $this->board->countCellTypeInLine(CellType::O, $line) === 2
            ) {
                return $this->getEmptyPlaceFromLine($line);
            }
        }
        return 0;
    }

    private function findLineWithOneO(): int
    {
        foreach (Board::ALL_POSSIBLE_WIN_LINES as $line) {
            if (
                $this->board->countCellTypeInLine(CellType::Empty, $line) === 2 &&
                $this->board->countCellTypeInLine(CellType::O, $line) === 1
            ) {
                return $this->getEmptyPlaceFromLine($line);
            }
        }
        return 0;
    }

    private function takeCenterIfFree(): int
    {
        if ($this->board->getCell(self::CENTER_PLACE)->isEmpty()) {
            return self::CENTER_PLACE;
        }
        return 0;
    }

    private function findEmptyLine(): int
    {
        foreach (Board::ALL_POSSIBLE_WIN_LINES as $line) {
            if ($this->board->countCellTypeInLine(CellType::Empty, $line) === 3) {
                return $this->getEmptyPlaceFromLine($line);
            }
        }
        return 0;
    }

    private function anyMove(): int
    {
        foreach (Board::ALL_POSSIBLE_WIN_LINES as $line) {
            if ($this->board->countCellTypeInLine(CellType::Empty, $line) > 0) {
                return $this->getEmptyPlaceFromLine($line);
            }
        }
        return 0;
    }

    /**
     * @param array<int> $line
     */
    private function getEmptyPlaceFromLine(array $line): int
    {
        $worsePlace = 0;
        foreach ($line as $place) {
            if ($this->board->getCell($place)->getType() === CellType::Empty) {
                if (in_array($place, self::GOOD_PLACES)) {
                    return $place;
                }
                $worsePlace = $place;
            }
        }
        if ($worsePlace) {
            return $worsePlace;
        }
        throw new \RuntimeException('Empty place not found');
    }
}
