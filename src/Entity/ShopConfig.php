<?php

namespace App\Entity;

use App\Repository\ShopConfigRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopConfigRepository::class)]
class ShopConfig
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $shopName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $shopDescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bannerMessage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instagramLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $twitterLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $facebookLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $supportEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $supportPhone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $aboutText = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShopName(): ?string
    {
        return $this->shopName;
    }

    public function setShopName(string $shopName): static
    {
        $this->shopName = $shopName;

        return $this;
    }

    public function getShopDescription(): ?string
    {
        return $this->shopDescription;
    }

    public function setShopDescription(?string $shopDescription): static
    {
        $this->shopDescription = $shopDescription;

        return $this;
    }

    public function getBannerMessage(): ?string
    {
        return $this->bannerMessage;
    }

    public function setBannerMessage(?string $bannerMessage): static
    {
        $this->bannerMessage = $bannerMessage;

        return $this;
    }

    public function getInstagramLink(): ?string
    {
        return $this->instagramLink;
    }

    public function setInstagramLink(?string $instagramLink): static
    {
        $this->instagramLink = $instagramLink;

        return $this;
    }

    public function getTwitterLink(): ?string
    {
        return $this->twitterLink;
    }

    public function setTwitterLink(?string $twitterLink): static
    {
        $this->twitterLink = $twitterLink;

        return $this;
    }

    public function getFacebookLink(): ?string
    {
        return $this->facebookLink;
    }

    public function setFacebookLink(?string $facebookLink): static
    {
        $this->facebookLink = $facebookLink;

        return $this;
    }

    public function getSupportEmail(): ?string
    {
        return $this->supportEmail;
    }

    public function setSupportEmail(?string $supportEmail): static
    {
        $this->supportEmail = $supportEmail;

        return $this;
    }

    public function getSupportPhone(): ?string
    {
        return $this->supportPhone;
    }

    public function setSupportPhone(?string $supportPhone): static
    {
        $this->supportPhone = $supportPhone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getAboutText(): ?string
    {
        return $this->aboutText;
    }

    public function setAboutText(?string $aboutText): static
    {
        $this->aboutText = $aboutText;

        return $this;
    }
}
