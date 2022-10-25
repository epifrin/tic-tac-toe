<?php

namespace App\Domain\GameResult;

use App\Domain\Board\Board;
use App\Domain\Cell\CellType;

class GameResultChecker
{
    private const WIN_ROUTES = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9],
        [1, 4, 7],
        [2, 5, 8],
        [3, 6, 9],
        [1, 5, 9],
        [3, 5, 7]
    ];

    public function check(Board $board): GameResult
    {
        if ($board->countMoves() < 5) {
            return new GameResult();
        }
        if ($board->countMoves() === 9) {
            return (new GameResult())->setDraw();
        }
        $routes = self::WIN_ROUTES;
        // exclude routes with empty place
        for ($place = 1; $place <= 9; $place++) {
            if ($board->getCell($place)->isEmpty()) {
                foreach ($routes as $index => $route) {
                    if (in_array($place, $route, true)) {
                        unset($routes[$index]);
                    }
                }
            }
            if (empty($routes)) {
                return new GameResult();
            }
        }
        $winner = $this->checkWinner(CellType::X, $routes, $board);
        if ($winner) {
            return $winner;
        }
        $winner = $this->checkWinner(CellType::O, $routes, $board);
        if ($winner) {
            return $winner;
        }

        return new GameResult();
    }

    /**
     * @param array<int, array<int>> $routes
     */
    private function checkWinner(CellType $cellType, array $routes, Board $board): ?GameResult
    {
        foreach ($routes as $route) {
            $countSameCell = 0;
            foreach ($route as $place) {
                if ($board->getCell($place)->getType() === $cellType) {
                    $countSameCell++;
                }
                if ($countSameCell === 3) {
                    if ($cellType === CellType::X) {
                        return (new GameResult())->setWinnerX();
                    }

                    return (new GameResult())->setWinnerO();
                }
            }
        }
        return null;
    }
}
