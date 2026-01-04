<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        // Ne pas traiter les sous-requêtes
        if (!$event->isMainRequest()) {
            return;
        }

        // Récupérer la locale depuis la session
        $locale = $request->getSession()->get('_locale', 'fr');

        // Liste des locales supportées
        $supportedLocales = ['fr', 'en'];

        if (!in_array($locale, $supportedLocales)) {
            $locale = 'fr';
        }

        // Définir la locale pour la requête
        $request->setLocale($locale);
    }
}