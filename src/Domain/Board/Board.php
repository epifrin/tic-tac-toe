<?php

declare(strict_types=1);

namespace App\Domain\Board;

use App\Domain\Cell\Cell;
use App\Domain\Cell\CellEmpty;
use App\Domain\Cell\CellType;

class Board
{
    /**
     * possible lines with places
     * 1 | 2 | 3
     * 4 | 5 | 6
     * 7 | 8 | 9
     */
    public const ALL_POSSIBLE_WIN_LINES = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9],
        [1, 4, 7],
        [2, 5, 8],
        [3, 6, 9],
        [1, 5, 9],
        [3, 5, 7]
    ];
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
