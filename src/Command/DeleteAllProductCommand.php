<?php

namespace App\Command;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:delete-all-products',
    description: 'Delete all products from the database',
)]
class DeleteAllProductCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $products = $this->entityManager->getRepository(Product::class)->findAll();
        $count = count($products);

        if ($count === 0) {
            $io->info('No products found to delete.');
            return Command::SUCCESS;
        }

        foreach ($products as $product) {
            $this->entityManager->remove($product);
        }

        $this->entityManager->flush();

        $io->success(sprintf('Successfully deleted %d product(s).', $count));

        return Command::SUCCESS;
    }
}
