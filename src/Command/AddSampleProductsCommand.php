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
    name: 'app:add-sample-products',
    description: 'Add sample products to the database',
)]
class AddSampleProductsCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $products = [
            [
                'name' => 'Clavier mécanique RGB',
                'description' => 'Clavier mécanique avec éclairage RGB personnalisable, switches Cherry MX.',
                'price' => '129.99',
                'image' => 'keyboard1.jpg',
            ],
            [
                'name' => 'Souris gaming ergonomique',
                'description' => 'Souris gaming avec capteur optique haute précision et design ergonomique.',
                'price' => '79.99',
                'image' => 'mouse1.jpg',
            ],
            [
                'name' => 'Écran 27" 4K',
                'description' => 'Écran 4K UHD avec panneau IPS, taux de rafraîchissement 144Hz.',
                'price' => '349.99',
                'image' => 'monitor1.jpg',
            ],
        ];

        foreach ($products as $productData) {
            $product = new Product();
            $product->setName($productData['name']);
            $product->setDescription($productData['description']);
            $product->setPrice($productData['price']);
            $product->setImage($productData['image']);

            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();

        $io->success('Sample products added successfully!');

        return Command::SUCCESS;
    }
}
