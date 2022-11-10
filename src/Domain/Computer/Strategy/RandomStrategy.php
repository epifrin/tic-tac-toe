<?php

namespace App\Domain\Computer\Strategy;

use App\Domain\Board\Board;
use App\Domain\Board\CellPlace;

class RandomStrategy implements Strategy
{
    public function getComputerMove(Board $board): CellPlace
    {
        do {
            $place = new CellPlace(\random_int(1, 9));
        } while ($board->getCell($place)->isEmpty() === false);

        return $place;
    }
}
