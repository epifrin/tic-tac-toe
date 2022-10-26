<?php

namespace App\Domain\Computer\Strategy;

use App\Domain\Board\Board;

interface StrategyInterface
{
    public function getComputerMove(Board $board): int;
}
