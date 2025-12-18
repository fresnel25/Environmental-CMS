<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreatedListener
{
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        /** @var \App\Entity\User $user */
        $user = $event->getUser();
        $payload = $event->getData();

        // Ajouter le tenant_id
        $payload['tenant_id'] = $user->getTenant()?->getId();

        // Ajouter l'id du user
        $payload['user_id'] = $user->getId();

        // Ajouter l'email
        $payload['email'] = $user->getEmail();

        // Ajouter les rôles
        $payload['roles'] = $user->getRoles();

        $event->setData($payload);
    }
}
