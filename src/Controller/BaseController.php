<?php

namespace App\Controller;

use App\Service\ShopConfiguration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    public function __construct(
        protected ShopConfiguration $shopConfig
    ) {}

    protected function getShopConfig(): array
    {
        return [
            'shop_name' => $this->shopConfig->getShopName(),
            'shop_description' => $this->shopConfig->getShopDescription(),
            'shop_email' => $this->shopConfig->getShopEmail(),
            'shop_phone' => $this->shopConfig->getShopPhone(),
            'shop_address' => $this->shopConfig->getShopAddress(),
        ];
    }
}