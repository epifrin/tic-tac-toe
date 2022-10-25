<?php

declare(strict_types=1);

namespace App\Domain\GameResult;

class GameResult
{
    private bool $hasResult = false;
    // win X or O or dead heat
    private bool $winnerX = false;
    private bool $winnerO = false;
    private bool $draw = false;

    public function __construct()
    {
    }

    public function isGameOver(): bool
    {
        return $this->hasResult;
    }

    public function isWinnerX(): bool
    {
        return $this->winnerX;
    }

    public function isWinnerO(): bool
    {
        return $this->winnerO;
    }

    public function isDraw(): bool
    {
        return $this->draw;
    }

    public function setWinnerX(): static
    {
        $this->hasResult = true;
        $this->winnerX = true;
        return $this;
    }

    public function setWinnerO(): static
    {
        $this->hasResult = true;
        $this->winnerO = true;
        return $this;
    }

    public function setDraw(): static
    {
        $this->hasResult = true;
        $this->draw = true;
        return $this;
    }
}
