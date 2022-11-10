<?php

namespace App\Domain\Computer\Strategy;

use App\Domain\Board\Board;
use App\Domain\Board\CellPlace;

interface Strategy
{
    /**
     * @param Board $board
     * @return CellPlace place on board
     */
    public function getComputerMove(Board $board): CellPlace;
}
