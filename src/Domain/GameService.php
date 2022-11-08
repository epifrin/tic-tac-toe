<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Board\Board;
use App\Domain\Cell\CellType;
use App\Domain\Computer\Strategy\Strategy;
use App\Domain\GameResult\GameResult;
use App\Domain\GameResult\GameResultChecker;

class GameService
{
    public function __construct(
        private readonly Strategy $strategy
    ) {
    }

    public function handleMove(Board $board, CellType $cellType, int $place): Board
    {
        return $board->setCell($cellType, $place);
    }

    public function makeComputerMove(Board $board): Board
    {
        $place = $this->strategy->getComputerMove($board);
        return $this->handleMove($board, CellType::O, $place);
    }

    public function checkResult(Board $board): GameResult
    {
        return (new GameResultChecker())->check($board);
    }
}
