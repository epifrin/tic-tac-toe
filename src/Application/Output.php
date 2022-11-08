<?php

namespace App\Application;

use App\Domain\Board\Board;
use App\Domain\GameResult\GameResult;

interface Output
{
    public function showStartScreen(): void;
    public function renderBoard(Board $board): void;
    public function showGameResult(GameResult $gameResult): void;
    public function showError(string $message): void;
    public function clear(): void;
}
