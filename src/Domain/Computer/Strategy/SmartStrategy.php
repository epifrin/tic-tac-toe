<?php

namespace App\Domain\Computer\Strategy;

use App\Domain\Board\Board;
use App\Domain\Cell\CellType;

class SmartStrategy implements StrategyInterface
{
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
            if ($this->isFulfilledLine($line)) {
                continue;
            }
            // find line that need to be defenced
            if (
                $this->countElemsInLine(CellType::Empty, $line) === 1 &&
                $this->countElemsInLine(CellType::X, $line) === 2
            ) {
                return $this->getEmptyPlaceFromLine($line);
            }
        }
        return 0;
    }

    private function getAttackMove(): int
    {
        $linesWithOneO = [];
        $emptyLines = [];
        $otherLines = [];
        foreach (Board::ALL_POSSIBLE_WIN_LINES as $line) {
            if ($this->isFulfilledLine($line)) {
                continue;
            }
            // find line with two O
            if (
                $this->countElemsInLine(CellType::Empty, $line) === 1 &&
                $this->countElemsInLine(CellType::O, $line) === 2
            ) {
                return $this->getEmptyPlaceFromLine($line);
            }
            // find line with one O
            if (
                $this->countElemsInLine(CellType::Empty, $line) === 2 &&
                $this->countElemsInLine(CellType::O, $line) === 1
            ) {
                $linesWithOneO[] = $line;
                continue;
            }
            // find empty line
            if (
                $this->countElemsInLine(CellType::Empty, $line) === 3
            ) {
                $emptyLines[] = $line;
                continue;
            }
            $otherLines[] = $line;
        }
        if (!empty($linesWithOneO)) {
            return $this->getEmptyPlaceFromLine($linesWithOneO[0]);
        }
        if ($this->board->getCell(5)->isEmpty()) {
            return 5;
        }
        if (!empty($emptyLines)) {
            return $this->getEmptyPlaceFromLine($emptyLines[0]);
        }

        return $this->getEmptyPlaceFromLine($otherLines[0]);
    }

    /**
     * @param array<int> $line
     */
    private function isFulfilledLine(array $line): bool
    {
        return $this->countElemsInLine(CellType::Empty, $line) === 0;
    }

    /**
     * @param array<int> $line
     */
    private function countElemsInLine(CellType $elem, array $line): int
    {
        $count = 0;
        foreach ($line as $place) {
            if ($this->board->getCell($place)->getType() === $elem) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * @param array<int> $line
     */
    private function getEmptyPlaceFromLine(array $line): int
    {
        foreach ($line as $place) {
            if ($this->board->getCell($place)->getType() === CellType::Empty) {
                return $place;
            }
        }
        throw new \RuntimeException('Empty place not found');
    }
}
