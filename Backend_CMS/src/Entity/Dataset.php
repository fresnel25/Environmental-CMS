<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\DatasetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DatasetRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(operations: [

    new GetCollection(security: "is_granted('ROLE_FOURNISSEUR_DONNEES') or is_granted('ROLE_ADMINISTRATEUR')"),
    new Get(security: "is_granted('ROLE_FOURNISSEUR_DONNEES') or is_granted('ROLE_ADMINISTRATEUR')", normalizationContext: ['groups' => ['dataset:read']]),
    new Post(securityPostDenormalize: "
        is_granted('ROLE_FOURNISSEUR_DONNEES') 
        or is_granted('ROLE_ADMINISTRATEUR')
    "),
    new Patch(security: "is_granted('ROLE_FOURNISSEUR_DONNEES') or is_granted('ROLE_ADMINISTRATEUR')"),
    new Delete(security: "is_granted('ROLE_ADMINISTRATEUR')")
])]
class Dataset extends AbstractTenantEntity implements TenantAwareInterface
{

    #[Groups(['dataset:read'])]
    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[Groups(['dataset:read'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Groups(['dataset:read'])]
    #[ORM\Column(length: 255)]
    private ?string $type_source = null;

    #[Groups(['dataset:read'])]
    #[ORM\Column(length: 255)]
    private ?string $url_source = null;

    #[Groups(['dataset:read'])]
    #[ORM\Column(length: 5, options: ['default' => ';'])]
    private ?string $delimiter = ';';

    /**
     * @var Collection<int, ColonneDataset>
     */
    #[Groups(['dataset:read'])]
    #[ORM\OneToMany(
        targetEntity: ColonneDataset::class,
        mappedBy: 'dataset',
        cascade: ['remove'],
        orphanRemoval: true
    )]
    private Collection $colonnes;

    /**
     * @var Collection<int, Visualisation>
     */
    #[ORM\OneToMany(
        targetEntity: Visualisation::class,
        mappedBy: 'dataset',
        cascade: ['remove'],
        orphanRemoval: true
    )]
    private Collection $visualisations;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $api_config = null;

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

    public function getApiConfig(): ?array
    {
        return $this->api_config;
    }

    public function setApiConfig(?array $api_config): static
    {
        $this->api_config = $api_config;

        return $this;
    }
}
