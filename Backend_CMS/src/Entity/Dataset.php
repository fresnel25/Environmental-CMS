<?php

namespace App\Entity;

use App\Repository\DatasetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DatasetRepository::class)]
class Dataset
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $type_source = null;

    #[ORM\Column(length: 255)]
    private ?string $url_source = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $delimiter = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTypeSource(): ?string
    {
        return $this->type_source;
    }

    public function setTypeSource(string $type_source): static
    {
        $this->type_source = $type_source;

        return $this;
    }

    public function getUrlSource(): ?string
    {
        return $this->url_source;
    }

    public function setUrlSource(string $url_source): static
    {
        $this->url_source = $url_source;

        return $this;
    }

    public function getDelimiter(): ?string
    {
        return $this->delimiter;
    }

    public function setDelimiter(?string $delimiter): static
    {
        $this->delimiter = $delimiter;

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
