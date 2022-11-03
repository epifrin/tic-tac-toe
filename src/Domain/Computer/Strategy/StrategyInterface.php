<?php

namespace App\Domain\Computer\Strategy;

use App\Domain\Board\Board;

interface StrategyInterface
{
    /**
     * @param Board $board
     * @return int place on board
     */
    public function getComputerMove(Board $board): int;
}
