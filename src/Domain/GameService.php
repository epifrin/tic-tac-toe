<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Board\Board;
use App\Domain\Board\CellPlace;
use App\Domain\Cell\CellType;
use App\Domain\Computer\Strategy\Strategy;
use App\Domain\GameResult\GameResult;
use App\Domain\GameResult\GameResultChecker;

class GameService
{
    private Board $board;

    public function __construct(
        private readonly Strategy $strategy,
        private readonly GameResultChecker $gameResultChecker,
    ) {
    }

    public function startNewGame(): void
    {
        $this->board = new Board();
    }

    public function handleUserMove(int $place): GameResult
    {
        $this->board->setCell(CellType::X, new CellPlace((int)$place));
        return $this->gameResultChecker->check($this->board);
    }

    public function makeComputerMove(): GameResult
    {
        $place = $this->strategy->getComputerMove($this->board);
        $this->board->setCell(CellType::O, $place);
        return $this->gameResultChecker->check($this->board);
    }

    public function getBoard(): Board
    {
        return $this->board;
    }
}
