<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Board\Board;
use App\Domain\Board\CellPlace;
use App\Domain\Cell\CellType;
use App\Domain\GameResult\GameResultChecker;
use App\Domain\GameService;

class GameController
{
    public function __construct(
        private readonly GameService $gameService,
        private readonly GameResultChecker $gameResultChecker
    ) {
    }

    public function index(Input $input, Output $output): void
    {
        $output->showStartScreen();

        $board = new Board();
        while (true) {
            $answer = $input->askMove();
            if ($answer === 'q' || $answer === 'quit') {
                break;
            }

            try {
                $place = new CellPlace((int)$answer);
                $board = $this->gameService->handleMove($board, CellType::X, $place);
                $output->clear();
                $output->renderBoard($board);

                $gameResult = $this->gameResultChecker->check($board);
                if ($gameResult->isGameOver()) {
                    $output->showGameResult($gameResult);
                    break;
                }

                // Computer move start
                sleep(1);
                $board = $this->gameService->makeComputerMove($board);
                $output->clear();
                $output->renderBoard($board);

                $gameResult = $this->gameResultChecker->check($board);
                if ($gameResult->isGameOver()) {
                    $output->showGameResult($gameResult);
                    break;
                }
                // Computer move end
            } catch (\DomainException $e) {
                $output->clear();
                $output->showError($e->getMessage());
                $output->renderBoard($board);
            }
        }
    }
}
