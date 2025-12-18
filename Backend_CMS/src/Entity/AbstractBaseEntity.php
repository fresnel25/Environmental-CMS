<?php
// src/Entity/AbstractBaseEntity.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class AbstractBaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column]
    protected \DateTimeImmutable $createdAt;

    #[ORM\Column]
    protected \DateTimeImmutable $updatedAt;

    #[ORM\PrePersist]
    public function onCreate(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
