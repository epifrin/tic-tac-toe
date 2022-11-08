<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Command;

use App\Application\GameController;
use App\Infrastructure\Console\Input\Input;
use App\Infrastructure\Console\Output\Output;
use LogicException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GameCommand extends Command
{
    protected static $defaultDescription = 'Run the game!';

    public function __construct(private readonly GameController $gameController, string $name = null)
    {
        parent::__construct($name);
    }

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
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        try {
            $this->gameController->index(new Input($input, $section, $helper), new Output($section));
        } catch (\Exception $e) {
            $section->writeln('<error>' . $e->getMessage() . '</error>');
        }
        return Command::SUCCESS;
    }
}
