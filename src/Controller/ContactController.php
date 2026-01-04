<?php

namespace App\Controller;

use App\Service\ShopConfiguration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends BaseController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
        return $this->render('contact/index.html.twig', $this->getShopConfig());
    }
}