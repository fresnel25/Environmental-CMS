<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\ColonneDatasetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColonneDatasetRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(operations: [
    new GetCollection(security: "is_granted('ROLE_DATA_PROVIDER') or is_granted('ROLE_ADMINISTRATEUR')"),
    new Get(security: "is_granted('ROLE_DATA_PROVIDER') or is_granted('ROLE_ADMINISTRATEUR')"),
    new Post(securityPostDenormalize: "is_granted('ROLE_DATA_PROVIDER') or is_granted('ROLE_ADMINISTRATEUR')"),
    new Patch(security: "is_granted('ROLE_DATA_PROVIDER') or is_granted('ROLE_ADMINISTRATEUR')"),
    new Delete(security: "is_granted('ROLE_ADMINISTRATEUR')")
])]
class ColonneDataset
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_colonne = null;

    #[ORM\Column(length: 255)]
    private ?string $type_colonne = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'colonnes')]
    private ?Dataset $dataset = null;

    #[ORM\ManyToOne(inversedBy: 'colonneDatasets')]
    private ?Tenant $tenant = null;

    #[ORM\ManyToOne(inversedBy: 'colonneDatasets')]
    private ?User $created_by = null;

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->created_at = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updated_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomColonne(): ?string
    {
        return $this->nom_colonne;
    }

    public function setNomColonne(string $nom_colonne): static
    {
        $this->nom_colonne = $nom_colonne;

        return $this;
    }

    public function getTypeColonne(): ?string
    {
        return $this->type_colonne;
    }

    public function setTypeColonne(string $type_colonne): static
    {
        $this->type_colonne = $type_colonne;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDataset(): ?Dataset
    {
        return $this->dataset;
    }

    public function setDataset(?Dataset $dataset): static
    {
        $this->dataset = $dataset;

        return $this;
    }

    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function setTenant(?Tenant $tenant): static
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): static
    {
        $this->created_by = $created_by;

        return $this;
    }
}
