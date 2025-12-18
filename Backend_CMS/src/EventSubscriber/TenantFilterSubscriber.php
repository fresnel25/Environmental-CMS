<?php
// src/EventSubscriber/TenantFilterSubscriber.php


namespace App\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Security;

final class TenantFilterSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $em
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [ RequestEvent::class => 'onKernelRequest' ];
    }
// Active le filtre a chaque requète
   public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) return;

         /** @var \App\Entity\User $user */
        $user = $this->security->getUser();
        if (!$user) return;

        $filter = $this->em->getFilters()->enable('tenant');
        $filter->setParameter('tenant_id', $user->getTenant()->getId());
    }
}