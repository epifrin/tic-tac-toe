<?php

declare(strict_types=1);

namespace App\Domain\Board;

class CellPlace
{
    private const MIN_PLACE = 1;
    private const MAX_PLACE = 9;

    private readonly int $place;

    public function __construct(int $place)
    {
        if ($place < self::MIN_PLACE || $place > self::MAX_PLACE) {
            throw new \DomainException('Incorrect place. Please enter correct place');
        }
        $this->place = $place;
    }

    public function value(): int
    {
        return $this->place;
    }
}
