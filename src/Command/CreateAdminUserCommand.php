<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin-user',
    description: 'Creates a new admin user.',
)]
class CreateAdminUserCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::REQUIRED, 'The username of the admin user.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the admin user.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        // Check if user already exists
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);

        if ($existingUser) {
            $existingUser->setRoles(['ROLE_ADMIN']);
            $hashedPassword = $this->passwordHasher->hashPassword($existingUser, $password);
            $existingUser->setPassword($hashedPassword);
            $user = $existingUser;
            $action = 'updated';
        } else {
            $user = new User();
            $user->setUsername($username);
            $user->setRoles(['ROLE_ADMIN']);
            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);
            $action = 'created';
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln("Admin user {$action} successfully.");

        return Command::SUCCESS;
    }
}