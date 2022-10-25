<?php

namespace App\Domain\Cell;

enum CellType
{
    case X;
    case O;
    case Empty;

    public function getCell(): Cell
    {
        return self::getCellByType($this);
    }

    public static function getCellByType(CellType $cellType): Cell
    {
        return match ($cellType) {
            self::X => new CellX(),
            self::O => new CellO(),
            self::Empty => new CellEmpty()
        };
    }
}
