<?php

namespace App\EventSubscriber;

use App\Entity\Theme;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;

class ThemeSubscriber implements EventSubscriber
{
    public function __construct(
        private Security $security
    ) {}

    public function getSubscribedEvents(): array
    {
        return [Events::prePersist];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Theme) {
            return;
        }

        /** @var \App\Entity\User $user */

        $user = $this->security->getUser();

        if (!$user) {
            return;
        }

        //  AUTOMATIQUE
        $entity->setCreatedBy($user);
        $entity->setTenant($user->getTenant());
        $entity->setActive(true);
    }
}
