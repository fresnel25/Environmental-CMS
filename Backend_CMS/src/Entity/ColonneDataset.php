<?php

namespace App\Entity;

use App\Repository\ColonneDatasetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColonneDatasetRepository::class)]
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
}
