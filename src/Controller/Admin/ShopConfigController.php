<?php

namespace App\Controller\Admin;

use App\Entity\ShopConfig;
use App\Form\ShopConfigType;
use App\Repository\ShopConfigRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/shop-config')]
class ShopConfigController extends AbstractController
{
    #[Route('/', name: 'app_admin_shop_config_index', methods: ['GET', 'POST'])]
    public function index(Request $request, ShopConfigRepository $shopConfigRepository, EntityManagerInterface $entityManager): Response
    {
        $shopConfig = $shopConfigRepository->findOneBy([]);
        
        if (!$shopConfig) {
            $shopConfig = new ShopConfig();
            $shopConfig->setShopName('Picokeebs');
        }

        $form = $this->createForm(ShopConfigType::class, $shopConfig);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$shopConfig->getId()) {
                 $entityManager->persist($shopConfig);
            }
            $entityManager->flush();

            $this->addFlash('success', 'Shop configuration updated successfully');

            return $this->redirectToRoute('app_admin_shop_config_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/shop_config/index.html.twig', [
            'shop_config' => $shopConfig,
            'form' => $form->createView(),
        ]);
    }
}
