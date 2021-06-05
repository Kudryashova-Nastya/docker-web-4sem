<?php


namespace App\Api\command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUser extends Command
{
    protected static $defaultName = 'app:create-user';

    /**
     * @var bool
     */

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $output->writeln($this->someMethod());

        return Command::SUCCESS;
    }

    private function someMethod(): string
    {
        return 'Hello, world';
    }
}
