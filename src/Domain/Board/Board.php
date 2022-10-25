<?php

declare(strict_types=1);

namespace App\Domain\Board;

use App\Domain\Cell\Cell;
use App\Domain\Cell\CellEmpty;
use App\Domain\Cell\CellType;

class Board
{
    /** @var Cell[] */
    private array $board = [];

    public function setCell(CellType $cellType, int $place): void
    {
        if (isset($this->board[$place])) {
            throw new \DomainException('This place is already taken');
        }
        $this->board[$place] = $cellType->getCell();
    }

    public function getCell(int $place): Cell
    {
        return $this->board[$place] ?? new CellEmpty();
    }

    public function countMoves(): int
    {
        return count($this->board);
    }

    /**
     * @return Cell[]
     */
    public function getBoard(): array
    {
        return $this->board;
    }
}
