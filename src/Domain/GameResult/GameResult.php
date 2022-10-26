<?php

declare(strict_types=1);

namespace App\Domain\GameResult;

use App\Domain\Cell\CellType;

class GameResult
{
    private bool $hasResult = false;
    private ?CellType $winner = null;
    private bool $draw = false;

    public function isGameOver(): bool
    {
        return $this->hasResult;
    }

    public function isWinnerX(): bool
    {
        return $this->winner === CellType::X;
    }

    public function isWinnerO(): bool
    {
        return $this->winner === CellType::O;
    }

    public function isDraw(): bool
    {
        return $this->draw;
    }

    public function hasWinner(): bool
    {
        return isset($this->winner);
    }

    public function setWinner(CellType $winner): static
    {
        $this->hasResult = true;
        $this->winner = $winner;
        return $this;
    }

    public function setDraw(): static
    {
        $this->hasResult = true;
        $this->draw = true;
        return $this;
    }
}
