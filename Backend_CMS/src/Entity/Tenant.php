<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TenantRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource]
class Tenant extends AbstractBaseEntity
{

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'tenants')]
    private ?Plan $plan = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'tenant')]
    private Collection $users;

    /**
     * @var Collection<int, Article>
     */
    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'tenant')]
    private Collection $articles;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'tenant')]
    private Collection $notes;

    /**
     * @var Collection<int, Bloc>
     */
    #[ORM\OneToMany(targetEntity: Bloc::class, mappedBy: 'tenant')]
    private Collection $blocs;

    /**
     * @var Collection<int, Media>
     */
    #[ORM\OneToMany(targetEntity: Media::class, mappedBy: 'tenant')]
    private Collection $media;

    /**
     * @var Collection<int, ColonneDataset>
     */
    #[ORM\OneToMany(targetEntity: ColonneDataset::class, mappedBy: 'tenant')]
    private Collection $colonneDatasets;

    /**
     * @var Collection<int, Dataset>
     */
    #[ORM\OneToMany(targetEntity: Dataset::class, mappedBy: 'tenant')]
    private Collection $datasets;

    /**
     * @var Collection<int, Visualisation>
     */
    #[ORM\OneToMany(targetEntity: Visualisation::class, mappedBy: 'tenant')]
    private Collection $visualisations;

    /**
     * @var Collection<int, Theme>
     */
    #[ORM\OneToMany(targetEntity: Theme::class, mappedBy: 'tenant')]
    private Collection $themes;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->blocs = new ArrayCollection();
        $this->media = new ArrayCollection();
        $this->colonneDatasets = new ArrayCollection();
        $this->datasets = new ArrayCollection();
        $this->visualisations = new ArrayCollection();
        $this->themes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPlan(): ?Plan
    {
        return $this->plan;
    }

    public function setPlan(?Plan $plan): static
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }


    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }


    /**
     * @return Collection<int, Bloc>
     */
    public function getBlocs(): Collection
    {
        return $this->blocs;
    }


    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }


    /**
     * @return Collection<int, ColonneDataset>
     */
    public function getColonneDatasets(): Collection
    {
        return $this->colonneDatasets;
    }


    /**
     * @return Collection<int, Dataset>
     */
    public function getDatasets(): Collection
    {
        return $this->datasets;
    }

    /**
     * @return Collection<int, Visualisation>
     */
    public function getVisualisations(): Collection
    {
        return $this->visualisations;
    }

    /**
     * @return Collection<int, Theme>
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }
}
