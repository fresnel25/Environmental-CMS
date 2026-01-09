<?php
// src/Entity/TenantAwareInterface.php

namespace App\Entity;

interface TenantAwareInterface
{
    public function getTenant(): ?Tenant;
}
