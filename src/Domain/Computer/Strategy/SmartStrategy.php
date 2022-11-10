<?php

namespace App\Domain\Computer\Strategy;

use App\Domain\Board\Board;
use App\Domain\Board\CellPlace;
use App\Domain\Cell\CellType;

class SmartStrategy implements Strategy
{
    private const CENTER_PLACE = 5;
    private const GOOD_PLACES = [1, 3, 5, 7, 9];

    private Board $board;

    public function getComputerMove(Board $board): CellPlace
    {
        $this->board = $board;

        $winMove = $this->findWinMove();
        if ($winMove) {
            return $winMove;
        }

        $defenceMove = $this->getDefenceMove();
        if ($defenceMove) {
            return $defenceMove;
        }

        return $this->getAttackMove();
    }

    private function getDefenceMove(): ?CellPlace
    {
        foreach (Board::ALL_POSSIBLE_WIN_LINES as $line) {
            if (
                $this->board->countCellTypeInLine(CellType::X, $line) === 2 &&
                $this->board->countCellTypeInLine(CellType::Empty, $line) === 1
            ) {
                return $this->getEmptyPlaceFromLine($line);
            }
        }
        return null;
    }

    private function getAttackMove(): CellPlace
    {
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

    private function findWinMove(): ?CellPlace
    {
        foreach (Board::ALL_POSSIBLE_WIN_LINES as $line) {
            if (
                $this->board->countCellTypeInLine(CellType::Empty, $line) === 1 &&
                $this->board->countCellTypeInLine(CellType::O, $line) === 2
            ) {
                return $this->getEmptyPlaceFromLine($line);
            }
        }
        return null;
    }

    private function findLineWithOneO(): ?CellPlace
    {
        foreach (Board::ALL_POSSIBLE_WIN_LINES as $line) {
            if (
                $this->board->countCellTypeInLine(CellType::Empty, $line) === 2 &&
                $this->board->countCellTypeInLine(CellType::O, $line) === 1
            ) {
                return $this->getEmptyPlaceFromLine($line);
            }
        }
        return null;
    }

    private function takeCenterIfFree(): ?CellPlace
    {
        if ($this->board->getCell(new CellPlace(self::CENTER_PLACE))->isEmpty()) {
            return new CellPlace(self::CENTER_PLACE);
        }
        return null;
    }

    private function findEmptyLine(): ?CellPlace
    {
        foreach (Board::ALL_POSSIBLE_WIN_LINES as $line) {
            if ($this->board->countCellTypeInLine(CellType::Empty, $line) === 3) {
                return $this->getEmptyPlaceFromLine($line);
            }
        }
        return null;
    }

    private function anyMove(): CellPlace
    {
        foreach (Board::ALL_POSSIBLE_WIN_LINES as $line) {
            if ($this->board->countCellTypeInLine(CellType::Empty, $line) > 0) {
                return $this->getEmptyPlaceFromLine($line);
            }
        }
        throw new \DomainException('No possible moves');
    }

    /**
     * @param array<int> $line
     */
    private function getEmptyPlaceFromLine(array $line): CellPlace
    {
        $worsePlace = 0;
        foreach ($line as $place) {
            if ($this->board->getCell(new CellPlace($place))->getType() === CellType::Empty) {
                if (in_array($place, self::GOOD_PLACES)) {
                    return new CellPlace($place);
                }
                $worsePlace = $place;
            }
        }
        if ($worsePlace) {
            return new CellPlace($worsePlace);
        }
        throw new \RuntimeException('Empty place not found');
    }
}
