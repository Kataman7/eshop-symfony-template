<?php

namespace App\Command;

use App\Entity\Product;
use App\Entity\ProductImage;
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

        // Check if products already exist
        $existingProducts = $this->entityManager->getRepository(Product::class)->findAll();
        if (count($existingProducts) > 0) {
            $io->info('Sample products already exist. Skipping creation.');
            return Command::SUCCESS;
        }

        $products = [
            [
                'name' => 'Clavier mécanique RGB',
                'description' => 'Clavier mécanique avec éclairage RGB personnalisable, switches Cherry MX.',
                'price' => '129.99',
                'images' => ['keyboard1.jpg', 'keyboard2.jpg', 'keyboard3.jpg'],
            ],
            [
                'name' => 'Souris gaming ergonomique',
                'description' => 'Souris gaming avec capteur optique haute précision et design ergonomique.',
                'price' => '79.99',
                'images' => ['mouse1.jpg', 'mouse2.jpg'],
            ],
            [
                'name' => 'Écran 27" 4K',
                'description' => 'Écran 4K UHD avec panneau IPS, taux de rafraîchissement 144Hz.',
                'price' => '349.99',
                'images' => ['monitor1.jpg', 'monitor2.jpg'],
            ],
        ];

        foreach ($products as $productData) {
            $product = new Product();
            $product->setName($productData['name']);
            $product->setDescription($productData['description']);
            $product->setPrice($productData['price']);

            // Create product images
            foreach ($productData['images'] as $index => $imageName) {
                $productImage = new ProductImage();
                $productImage->setImageName($imageName);
                $productImage->setPosition($index);
                $product->addImage($productImage);
            }

            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();

        $io->success('Sample products added successfully!');

        return Command::SUCCESS;
    }
}
