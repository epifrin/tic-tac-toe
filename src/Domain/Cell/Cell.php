<?php

namespace App\Domain\Cell;

abstract class Cell
{
    public function isX(): bool
    {
        return false;
    }

    public function isO(): bool
    {
        return false;
    }

    public function isEmpty(): bool
    {
        return false;
    }

    abstract public function getType(): CellType;
}
