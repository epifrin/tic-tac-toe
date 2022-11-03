<?php

namespace App\Domain\Computer\Strategy;

use App\Domain\Board\Board;

class RandomStrategy implements StrategyInterface
{
    public function getComputerMove(Board $board): int
    {
        do {
            $place = \random_int(1, 9);
        } while ($board->getCell($place)->isEmpty() === false);

        return $place;
    }
}
