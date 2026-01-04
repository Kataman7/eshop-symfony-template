<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ShopConfiguration
{
    public function __construct()
    {
    }

    public function getShopName(): string
    {
        return $_ENV['SHOP_NAME'] ?? 'Picokeebs';
    }

    public function getShopDescription(): string
    {
        return $_ENV['SHOP_DESCRIPTION'] ?? 'Votre boutique en ligne de claviers mécaniques et accessoires gaming';
    }

    public function getShopEmail(): string
    {
        return $_ENV['SHOP_EMAIL'] ?? 'contact@picokeebs.com';
    }

    public function getShopPhone(): string
    {
        return $_ENV['SHOP_PHONE'] ?? '+33 1 23 45 67 89';
    }

    public function getShopAddress(): string
    {
        return $_ENV['SHOP_ADDRESS'] ?? 'Paris, France';
    }
}