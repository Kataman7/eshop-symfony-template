<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\StripeClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    public function __construct(
        private StripeClient $stripeClient,
        private EntityManagerInterface $entityManager,
        private ProductRepository $productRepository,
    ) {}

    #[Route('/checkout', name: 'app_checkout')]
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {
        $cart = $session->get('cart', []);
        if (empty($cart)) {
            return $this->redirectToRoute('app_cart');
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $item) {
            $product = $productRepository->find($item['id']);
            if ($product) {
                $subtotal = (float) $product->getPrice() * $item['quantity'];
                $total += $subtotal;
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ];
            }
        }

        return $this->render('checkout/index.html.twig', [
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }

    #[Route('/checkout/process', name: 'app_checkout_process', methods: ['POST'])]
    public function process(Request $request, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        if (empty($cart)) {
            return $this->redirectToRoute('app_cart');
        }

        $data = $request->request->all();
        $email = $data['email'] ?? null;

        if (!$email) {
            $this->addFlash('error', 'Email requis');
            return $this->redirectToRoute('app_checkout');
        }

        $lineItems = [];
        $total = 0;
        $orderItems = [];

        foreach ($cart as $item) {
            $product = $this->productRepository->find($item['id']);
            if (!$product) {
                continue;
            }
            $quantity = $item['quantity'];
            $price = (float) $product->getPrice();
            $subtotal = $price * $quantity;
            $total += $subtotal;
            $orderItems[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $price,
                'quantity' => $quantity,
            ];
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $product->getName(),
                        'description' => $product->getDescription(),
                    ],
                    'unit_amount' => (int) ($price * 100),
                ],
                'quantity' => $quantity,
            ];
        }

        $order = new Order();
        $order->setEmail($email);
        $order->setItems($orderItems);
        $order->setTotal((string) $total);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $session = $this->stripeClient->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $this->generateUrl('app_checkout_success', [], \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('app_store', [], \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL),
            'customer_email' => $email,
            'metadata' => [
                'order_id' => $order->getId(),
            ],
        ]);

        $order->setStripeSessionId($session->id);
        $this->entityManager->flush();

        // Vider le panier après création de la session
        $session->remove('cart');

        return $this->redirect($session->url);
    }

    #[Route('/checkout/success', name: 'app_checkout_success')]
    public function success(): Response
    {
        return $this->render('checkout/success.html.twig');
    }
}