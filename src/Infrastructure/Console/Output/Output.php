<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Output;

use App\Domain\Board\Board;
use App\Domain\Board\CellPlace;
use App\Domain\GameResult\GameResult;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

class Output implements \App\Application\Output
{
    public function __construct(private readonly ConsoleSectionOutput $section)
    {
    }

    public function showStartScreen(): void
    {
        $this->section->writeln('Hello! It is Tic Tac Toe Game');
        $this->renderBoard(new Board());
    }

    public function renderBoard(Board $board): void
    {
        $place = 1;
        for ($i = 1; $i <= 3; $i++) {
            $lineItems = [];
            for ($j = 1; $j <= 3; $j++) {
                $cell = $board->getCell(new CellPlace($place));
                if ($cell->isX()) {
                    $lineItems[] = '<fg=red;options=bold>' . $cell->getSymbol() . '</>';
                } elseif ($cell->isO()) {
                    $lineItems[] = '<fg=green;options=bold>' . $cell->getSymbol() . '</>';
                } else {
                    $lineItems[] = '<fg=gray>' . $place . '</>';
                }
                $place++;
            }
            $this->section->writeln(implode(' | ', $lineItems));
        }
    }

    public function showGameResult(GameResult $gameResult): void
    {
        if ($gameResult->isDraw()) {
            $this->section->writeln('It is draw. Try one more time!');
        }
        if ($gameResult->isWinnerX()) {
            $this->section->writeln('<success>You win!</success>');
        }
        if ($gameResult->isWinnerO()) {
            $this->section->writeln('<error>You lose</error>');
        }
    }

    public function showError(string $message): void
    {
        $this->section->writeln('<error>' . $message . '</error>');
    }

    public function clear(): void
    {
        $this->section->clear();
    }
}
