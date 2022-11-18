<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\GameResult\GameResult;
use App\Domain\GameService;

class GameController
{
    public function __construct(
        private readonly GameService $gameService
    ) {
    }

    public function index(Input $input, Output $output): void
    {
        $output->showStartScreen();

        $this->gameService->startNewGame();
        while (true) {
            $answer = $input->askMove();
            if ($answer === 'q' || $answer === 'quit') {
                break;
            }

            try {
                $gameResult = $this->gameService->handleUserMove((int)$answer);
                $isGameOver = $this->showBoardAndGameResult($gameResult, $output);
                if ($isGameOver) {
                    break;
                }

                sleep(1);
                $gameResult = $this->gameService->makeComputerMove();
                $isGameOver = $this->showBoardAndGameResult($gameResult, $output);
                if ($isGameOver) {
                    break;
                }
            } catch (\DomainException $e) {
                $output->clear();
                $output->showError($e->getMessage());
                $output->renderBoard($this->gameService->getBoard());
            }
        }
    }

    private function showBoardAndGameResult(GameResult $gameResult, Output $output): bool
    {
        $output->clear();
        $output->renderBoard($this->gameService->getBoard());
        if ($gameResult->isGameOver()) {
            $output->showGameResult($gameResult);
            return true;
        }
        return false;
    }
}
