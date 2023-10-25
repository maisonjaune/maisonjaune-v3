<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'app:init',
    description: "Initialisation de l'application",
)]
class InitCommand extends Command
{
    public function __construct(
        private KernelInterface $kernel,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = microtime(true);

        $io = new SymfonyStyle($input, $output);
        $io->section("Initialisation");

        $this->removeFiles($io, $output);
        $this->dropDatabase($io, $output);
        $this->createDatabase($io, $output);

        $this->executeMigration($io, $output);

        $this->executeFixture($io, $output);

        $end = microtime(true);

        $seconds = $end - $start;

        $minutes = floor($seconds / 60);
        $rest = floor($seconds - ($minutes * 60));

        $io->success(sprintf("Execution time : %dmin %dsec", $minutes, $rest));

        return Command::SUCCESS;
    }

    private function removeFiles(SymfonyStyle $io, OutputInterface $output)
    {
        if ($this->kernel->getEnvironment() !== 'test') {
            $folders = [];

            $fileSystem = new Filesystem();
            foreach ($folders as $folder) {
                $fileSystem->remove($folder);
                $fileSystem->mkdir($folder);
            }

            $io->success("Files removed successfully");
        }
    }

    private function dropDatabase(SymfonyStyle $io, OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:database:drop');
        $argument = new ArrayInput([
            '--force' => true
        ]);
        $command->run($argument, $output);
        $io->success("Database dropped successfully");
    }

    private function createDatabase(SymfonyStyle $io, OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:database:create');
        $argument = new ArrayInput([]);
        $command->run($argument, $output);
        $io->success("Database created successfully");
    }

    private function executeMigration(SymfonyStyle $io, OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:migrations:migrate');
        $argument = new ArrayInput([
            '--no-interaction' => true,
            '--all-or-nothing' => true,
        ]);
        $argument->setInteractive(false);
        $command->run($argument, $output);
        $io->success("Migrations executed successfully");
    }

    private function executeFixture(SymfonyStyle $io, OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:fixtures:load');
        $argument = new ArrayInput([
            '--append' => true,
        ]);
        $command->run($argument, $output);
        $io->success("Fixtures loaded successfully");
    }
}