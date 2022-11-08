<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Board\Board;
use App\Domain\Cell\CellType;
use App\Domain\GameService;

class GameController
{
    public function __construct(private readonly GameService $gameService)
    {
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
            if ($answer >= 1 && $answer <= 9) {
                $output->clear();
                try {
                    $board = $this->gameService->handleMove($board, CellType::X, (int)$answer);
                    $output->renderBoard($board);
                    $gameResult = $this->gameService->checkResult($board);
                    if ($gameResult->isGameOver()) {
                        $output->showGameResult($gameResult);
                        break;
                    }

                    sleep(1);
                    // random Computer move start
                    $board = $this->gameService->makeComputerMove($board);
                    $output->clear();
                    $output->renderBoard($board);

                    $gameResult = $this->gameService->checkResult($board);
                    if ($gameResult->isGameOver()) {
                        $output->showGameResult($gameResult);
                        break;
                    }
                    // random Computer move end
                } catch (\Exception $e) {
                    $output->clear();
                    $output->showError($e->getMessage());
                    $output->renderBoard($board);
                }
            } else {
                $output->showError('Incorrect move. Please try one more time');
            }
        }
    }
}
