<?php

namespace App\Domain\Computer\Strategy;

use App\Domain\Board\Board;
use App\Domain\Board\CellPlace;

interface Strategy
{
    /**
     * @return CellPlace place on board
     */
    public function getComputerMove(Board $board): CellPlace;
}
