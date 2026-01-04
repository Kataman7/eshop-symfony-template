<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocaleController extends AbstractController
{
    #[Route('/change-locale/{locale}', name: 'app_change_locale')]
    public function changeLocale(string $locale, Request $request): Response
    {
        // Liste des locales supportées
        $supportedLocales = ['fr', 'en'];

        if (!in_array($locale, $supportedLocales)) {
            $locale = 'fr'; // Locale par défaut
        }

        // Stocker la locale dans la session
        $request->getSession()->set('_locale', $locale);

        // Rediriger vers la page précédente ou la page d'accueil
        $referer = $request->headers->get('referer');
        if ($referer) {
            return $this->redirect($referer);
        }

        return $this->redirectToRoute('app_store');
    }
}