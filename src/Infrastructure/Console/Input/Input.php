<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Input;

use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Question\Question;

class Input implements \App\Application\Input
{
    public function __construct(
        private readonly InputInterface $input,
        private readonly ConsoleSectionOutput $section,
        private readonly QuestionHelper $questionHelper
    ) {
    }

    public function askMove(): string
    {
        $question = new Question('Please enter your move (from 1 to 9 or q to quit): ', 0);
        /** @var string $answer */
        $answer = $this->questionHelper->ask($this->input, $this->section, $question);
        return $answer;
    }
}
