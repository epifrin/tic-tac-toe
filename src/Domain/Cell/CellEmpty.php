<?php

namespace App\Domain\Cell;

class CellEmpty extends Cell
{
    public function getType(): CellType
    {
        return CellType::Empty;
    }

    public function isEmpty(): bool
    {
        return true;
    }
}
