<?php

declare(strict_types=1);

namespace App\Application\Console\Command;

use App\Domain\Board\Board;
use App\Domain\Cell\CellType;
use App\Domain\Computer\Strategy\RandomStrategy;
use App\Domain\GameResult\GameResult;
use App\Domain\GameService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use LogicException;

class GameCommand extends Command
{
    protected static $defaultDescription = 'Run the game!';

    protected function configure(): void
    {
        $this->setName('game');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$output instanceof ConsoleOutputInterface) {
            throw new LogicException('This command accepts only an instance of "ConsoleOutputInterface".');
        }
        $section = $output->section();

        $this->showStartScreen($section);

        $helper = $this->getHelper('question');
        $question = new Question('Please enter your move (from 1 to 9 or q to quit): ', 0);
        $board = new Board();
        $gameService = new GameService($board, new RandomStrategy());
        while (true) {
            $answer = $helper->ask($input, $section, $question);
            if ($answer === 'q' || $answer === 'quit') {
                break;
            }
            if ($answer >= 1 && $answer <= 9) {
                $section->clear();
                try {
                    $board = $gameService->handleMove(CellType::X, (int)$answer);
                    $this->renderBoard($board, $section);
                    $gameResult = $gameService->checkResult();
                    if ($gameResult->isGameOver()) {
                        $this->showGameResult($gameResult, $section);
                        break;
                    }

                    sleep(1);
                    // random Computer move start
                    $board = $gameService->makeComputerMove();
                    $section->clear();
                    $this->renderBoard($board, $section);

                    $gameResult = $gameService->checkResult();
                    if ($gameResult->isGameOver()) {
                        $this->showGameResult($gameResult, $section);
                        break;
                    }
                    // random Computer move end
                } catch (\Exception $e) {
                    $section->clear();
                    $section->writeln('<error>' . $e->getMessage() . '</error>');
                    $this->renderBoard($board, $section);
                }
            } else {
                $section->writeln('<error>Incorrect move. Please try one more time</error>');
            }
        }

        return Command::SUCCESS;
    }

    private function showStartScreen(ConsoleSectionOutput $section): void
    {
        $section->writeln('Hello! It is Tic Tac Toe Game');
        $this->renderBoard(new Board(), $section);
    }

    private function renderBoard(Board $board, ConsoleSectionOutput $section): void
    {
        $place = 1;
        for ($i = 1; $i <= 3; $i++) {
            $lineItems = [];
            for ($j = 1; $j <= 3; $j++) {
                $cell = $board->getCell($place);
                if ($cell->isX()) {
                    $lineItems[] = '<fg=red;options=bold>' . $cell->getSymbol() . '</>';
                } elseif ($cell->isO()) {
                    $lineItems[] = '<fg=green;options=bold>' . $cell->getSymbol() . '</>';
                } else {
                    $lineItems[] = '<fg=gray>' . $place . '</>';
                }
                $place++;
            }
            $section->writeln(implode(' | ', $lineItems));
        }
    }

    private function showGameResult(GameResult $gameResult, ConsoleSectionOutput $section): void
    {
        if ($gameResult->isDraw()) {
            $section->writeln('It is draw. Try one more time!');
        }
        if ($gameResult->isWinnerX()) {
            $section->writeln('You win!');
        }
        if ($gameResult->isWinnerO()) {
            $section->writeln('You lose');
        }
    }
}
