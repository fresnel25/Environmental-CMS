<?php
// src/Doctrine/TenantFilter.php

namespace App\Doctrine;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class TenantFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, string $alias): string
    {
        // On filtre uniquement les entités qui ont un champ tenant
        if (!$targetEntity->hasAssociation('tenant')) {
            return '';
        }

        return sprintf(
            '%s.tenant_id = %s',
            $alias,
            $this->getParameter('tenant_id')
        );
    }
}
