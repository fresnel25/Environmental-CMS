<?php

namespace App\Entity;

use App\Repository\VisualisationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisualisationRepository::class)]
class Visualisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type_visualisation = null;

    #[ORM\Column]
    private array $correspondance_json = [];

    #[ORM\Column(nullable: true)]
    private ?array $style_json = null;

    #[ORM\Column(nullable: true)]
    private ?array $filter_json = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $note = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeVisualisation(): ?string
    {
        return $this->type_visualisation;
    }

    public function setTypeVisualisation(string $type_visualisation): static
    {
        $this->type_visualisation = $type_visualisation;

        return $this;
    }

    public function getCorrespondanceJson(): array
    {
        return $this->correspondance_json;
    }

    public function setCorrespondanceJson(array $correspondance_json): static
    {
        $this->correspondance_json = $correspondance_json;

        return $this;
    }

    public function getStyleJson(): ?array
    {
        return $this->style_json;
    }

    public function setStyleJson(?array $style_json): static
    {
        $this->style_json = $style_json;

        return $this;
    }

    public function getFilterJson(): ?array
    {
        return $this->filter_json;
    }

    public function setFilterJson(?array $filter_json): static
    {
        $this->filter_json = $filter_json;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->note = $note;

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
