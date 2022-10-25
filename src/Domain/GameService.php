<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Board\Board;
use App\Domain\Cell\CellType;
use App\Domain\GameResult\GameResult;
use App\Domain\GameResult\GameResultChecker;

class GameService
{
    public function __construct(private Board $board)
    {
    }

    public function handleMove(CellType $cellType, int $place): Board
    {
        $this->board->setCell($cellType, $place);
        return $this->board;
    }

    public function checkResult(): GameResult
    {
        return (new GameResultChecker())->check($this->board);
    }
}
