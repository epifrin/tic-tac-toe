<?php

namespace App\Domain\Cell;

class CellX extends Cell
{
    public function getType(): CellType
    {
        return CellType::X;
    }

    public function isX(): bool
    {
        return true;
    }
}
