<?php

/**
 * This file is part of RoadRunner package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spiral\RoadRunner\Console;

use Spiral\RoadRunner\Console\Repository\GitHub\GitHubRepository;
use Spiral\RoadRunner\Console\Repository\RepositoryInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class Command extends BaseCommand
{
    /**
     * @return RepositoryInterface
     */
    protected function getRepository(): RepositoryInterface
    {
        return GitHubRepository::createFromGlobals();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return StyleInterface
     */
    protected function io(InputInterface $input, OutputInterface $output): StyleInterface
    {
        return new SymfonyStyle($input, $output);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $out
     * @param string $message
     * @return bool
     */
    protected function confirm(InputInterface $input, OutputInterface $out, string $message): bool
    {
        $question = new ConfirmationQuestion($message);

        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        return (bool)$helper->ask($input, $out, $question);
    }
}