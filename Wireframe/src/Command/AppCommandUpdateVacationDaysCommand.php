<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:add-vacation-days')]
class AppCommandUpdateVacationDaysCommand extends Command
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('days', InputArgument::REQUIRED, 'Number of vacation days to add')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
            ->setDescription('Adds 20 days to employees each year')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $days = (int) $input->getArgument('days');
        
        $connection = $this->entityManager->getConnection();

        $sql = "UPDATE user 
                SET vacation_days = vacation_days + :days
                WHERE FIND_IN_SET('ROLE_ADMIN', roles) = 0";

        $params = ['days' => $days];
        
        $connection->executeStatement($sql, $params);

        $io->success('Successfully added '. $days .' days to each employee.');

        return Command::SUCCESS;
    }
}
