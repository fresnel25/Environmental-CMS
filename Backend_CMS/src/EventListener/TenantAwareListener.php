<?php

namespace App\EventListener;

use App\Entity\AbstractTenantEntity;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Symfony\Component\Security\Core\Security;

final class TenantAwareListener
{
    public function __construct(private Security $security) {}

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject(); // <-- on récupère l'entité réelle

        if (!$entity instanceof AbstractTenantEntity) {
            return;
        }

        /** @var \App\Entity\User $user */
        $user = $this->security->getUser();
        if (!$user) {
            return;
        }

        if (!$entity->getTenant()) {
            $entity->setTenant($user->getTenant());
        }

        if (!$entity->getCreatedBy()) {
            $entity->setCreatedBy($user);
        }
    }
}
