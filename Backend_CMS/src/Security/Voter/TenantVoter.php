<?php
// src/Security/Voter/TenantRoleVoter.php

namespace App\Security\Voter;

use App\Entity\TenantAwareInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TenantVoter extends Voter
{
    public const VIEW   = 'TENANT_VIEW';
    public const EDIT   = 'TENANT_EDIT';
    public const DELETE = 'TENANT_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $subject instanceof TenantAwareInterface
            && in_array($attribute, [self::VIEW, self::EDIT, self::DELETE], true);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false; // pas connecté
        }

        //  Super admin a tous les droits
        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles(), true)) {
            return true;
        }

        // Vérifie tenant
        if (!$subject instanceof TenantAwareInterface) {
            return false;
        }

        $userTenant = $user->getTenant();
        $subjectTenant = $subject->getTenant();

        if (!$userTenant || !$subjectTenant) {
            return false;
        }

        if ($userTenant->getId() !== $subjectTenant->getId()) {
            return false; // pas le même tenant
        }

        $userRoles = $user->getRoles();

        // Définition des permissions par rôle
        return match ($attribute) {
            self::VIEW => !empty(array_intersect(
                ['ROLE_ABONNE', 'ROLE_AUTEUR', 'ROLE_EDITEUR', 'ROLE_DESIGNER', 'ROLE_FOURNISSEUR_DONNEES', 'ROLE_ADMINISTRATEUR'], 
                $userRoles
            )),
            self::EDIT => !empty(array_intersect(
                ['ROLE_AUTEUR', 'ROLE_EDITEUR', 'ROLE_DESIGNER', 'ROLE_ADMINISTRATEUR'], 
                $userRoles
            )),
            self::DELETE => in_array('ROLE_ADMINISTRATEUR', $userRoles, true),
            default => false,
        };
    }
}
