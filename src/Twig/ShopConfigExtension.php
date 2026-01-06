<?php

namespace App\Twig;

use App\Repository\ShopConfigRepository;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFunction;

class ShopConfigExtension extends AbstractExtension implements GlobalsInterface
{
    private $shopConfigRepository;

    public function __construct(ShopConfigRepository $shopConfigRepository)
    {
        $this->shopConfigRepository = $shopConfigRepository;
    }

    public function getGlobals(): array
    {
        // Fetch the first config or null if none exists
        // Note: For high performance this should be cached, but for this scale it's fine.
        $config = $this->shopConfigRepository->findOneBy([]);
        
        return [
            'shop_config' => $config,
        ];
    }
}
