<?php

namespace App\Domain\Cell;

class CellO extends Cell
{
    public function getType(): CellType
    {
        return CellType::O;
    }

    public function isO(): bool
    {
        return true;
    }
}
