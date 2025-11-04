<?php

namespace App\Entity;

use App\Repository\DatasetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, ColonneDataset>
     */
    #[ORM\OneToMany(targetEntity: ColonneDataset::class, mappedBy: 'dataset')]
    private Collection $colonnes;

    /**
     * @var Collection<int, Visualisation>
     */
    #[ORM\OneToMany(targetEntity: Visualisation::class, mappedBy: 'dataset')]
    private Collection $visualisations;

    public function __construct()
    {
        $this->colonnes = new ArrayCollection();
        $this->visualisations = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, ColonneDataset>
     */
    public function getColonnes(): Collection
    {
        return $this->colonnes;
    }

    public function addColonne(ColonneDataset $colonne): static
    {
        if (!$this->colonnes->contains($colonne)) {
            $this->colonnes->add($colonne);
            $colonne->setDataset($this);
        }

        return $this;
    }

    public function removeColonne(ColonneDataset $colonne): static
    {
        if ($this->colonnes->removeElement($colonne)) {
            // set the owning side to null (unless already changed)
            if ($colonne->getDataset() === $this) {
                $colonne->setDataset(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Visualisation>
     */
    public function getVisualisations(): Collection
    {
        return $this->visualisations;
    }

    public function addVisualisation(Visualisation $visualisation): static
    {
        if (!$this->visualisations->contains($visualisation)) {
            $this->visualisations->add($visualisation);
            $visualisation->setDataset($this);
        }

        return $this;
    }

    public function removeVisualisation(Visualisation $visualisation): static
    {
        if ($this->visualisations->removeElement($visualisation)) {
            // set the owning side to null (unless already changed)
            if ($visualisation->getDataset() === $this) {
                $visualisation->setDataset(null);
            }
        }

        return $this;
    }
}
