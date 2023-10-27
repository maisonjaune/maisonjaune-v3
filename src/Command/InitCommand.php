<?php

namespace App\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'app:init',
    description: "Initialisation de l'application",
)]
class InitCommand extends Command
{
    public function __construct(
        private KernelInterface       $kernel,
        private ParameterBagInterface $parameterBag,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = microtime(true);

        $io = new SymfonyStyle($input, $output);

        $application = $this->getApplication();

        if (null === $application) {
            $io->success("Application not found");

            return Command::SUCCESS;
        }

        $io->section("Initialisation");

        $this->removeFiles($io, $output);
        $this->dropDatabase($application, $io, $output);
        $this->createDatabase($application, $io, $output);

        $this->executeMigration($application, $io, $output);

        $this->executeFixture($application, $io, $output);

        $end = microtime(true);

        $seconds = $end - $start;

        $minutes = floor($seconds / 60);
        $rest = floor($seconds - ($minutes * 60));

        $io->success(sprintf("Execution time : %dmin %dsec", $minutes, $rest));

        return Command::SUCCESS;
    }

    private function removeFiles(SymfonyStyle $io, OutputInterface $output): void
    {
        if ($this->kernel->getEnvironment() !== 'test') {

            $fileSystem = new Filesystem();

            $folders = $this->parameterBag->get('command.init.folder');

            if (is_array($folders)) {
                foreach ($folders as $folder) {
                    $fileSystem->remove($folder);
                    $fileSystem->mkdir($folder);
                }
            }

            $io->success("Files removed successfully");
        }
    }

    private function dropDatabase(Application $application, SymfonyStyle $io, OutputInterface $output): void
    {
        $command = $application->find('doctrine:database:drop');
        $argument = new ArrayInput([
            '--force' => true
        ]);
        $command->run($argument, $output);
        $io->success("Database dropped successfully");
    }

    private function createDatabase(Application $application, SymfonyStyle $io, OutputInterface $output): void
    {
        $command = $application->find('doctrine:database:create');
        $argument = new ArrayInput([]);
        $command->run($argument, $output);
        $io->success("Database created successfully");
    }

    private function executeMigration(Application $application, SymfonyStyle $io, OutputInterface $output): void
    {
        $command = $application->find('doctrine:migrations:migrate');
        $argument = new ArrayInput([
            '--no-interaction' => true,
            '--all-or-nothing' => true,
        ]);
        $argument->setInteractive(false);
        $command->run($argument, $output);
        $io->success("Migrations executed successfully");
    }

    private function executeFixture(Application $application, SymfonyStyle $io, OutputInterface $output): void
    {
        $command = $application->find('doctrine:fixtures:load');
        $argument = new ArrayInput([
            '--append' => true,
        ]);
        $command->run($argument, $output);
        $io->success("Fixtures loaded successfully");
    }
}