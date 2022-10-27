<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Board\Board;
use App\Domain\Cell\CellType;
use App\Domain\Computer\Strategy\StrategyInterface;
use App\Domain\GameResult\GameResult;
use App\Domain\GameResult\GameResultChecker;

class GameService
{
    public function __construct(
        private readonly Board $board,
        private readonly StrategyInterface $strategy
    ) {
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

    public function makeComputerMove(): Board
    {
        $place = $this->strategy->getComputerMove($this->board);
        return $this->handleMove(CellType::O, $place);
    }
}
