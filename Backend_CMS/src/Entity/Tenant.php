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
class Tenant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'tenants')]
    private ?Plan $plan = null;

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $now = new \DateTimeImmutable();
        $this->created_at = $now;
        $this->updated_at = $now;
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updated_at = new \DateTimeImmutable();
    }

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

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

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

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setTenant($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getTenant() === $this) {
                $user->setTenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setTenant($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getTenant() === $this) {
                $article->setTenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setTenant($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getTenant() === $this) {
                $note->setTenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bloc>
     */
    public function getBlocs(): Collection
    {
        return $this->blocs;
    }

    public function addBloc(Bloc $bloc): static
    {
        if (!$this->blocs->contains($bloc)) {
            $this->blocs->add($bloc);
            $bloc->setTenant($this);
        }

        return $this;
    }

    public function removeBloc(Bloc $bloc): static
    {
        if ($this->blocs->removeElement($bloc)) {
            // set the owning side to null (unless already changed)
            if ($bloc->getTenant() === $this) {
                $bloc->setTenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): static
    {
        if (!$this->media->contains($medium)) {
            $this->media->add($medium);
            $medium->setTenant($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): static
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getTenant() === $this) {
                $medium->setTenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ColonneDataset>
     */
    public function getColonneDatasets(): Collection
    {
        return $this->colonneDatasets;
    }

    public function addColonneDataset(ColonneDataset $colonneDataset): static
    {
        if (!$this->colonneDatasets->contains($colonneDataset)) {
            $this->colonneDatasets->add($colonneDataset);
            $colonneDataset->setTenant($this);
        }

        return $this;
    }

    public function removeColonneDataset(ColonneDataset $colonneDataset): static
    {
        if ($this->colonneDatasets->removeElement($colonneDataset)) {
            // set the owning side to null (unless already changed)
            if ($colonneDataset->getTenant() === $this) {
                $colonneDataset->setTenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Dataset>
     */
    public function getDatasets(): Collection
    {
        return $this->datasets;
    }

    public function addDataset(Dataset $dataset): static
    {
        if (!$this->datasets->contains($dataset)) {
            $this->datasets->add($dataset);
            $dataset->setTenant($this);
        }

        return $this;
    }

    public function removeDataset(Dataset $dataset): static
    {
        if ($this->datasets->removeElement($dataset)) {
            // set the owning side to null (unless already changed)
            if ($dataset->getTenant() === $this) {
                $dataset->setTenant(null);
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
            $visualisation->setTenant($this);
        }

        return $this;
    }

    public function removeVisualisation(Visualisation $visualisation): static
    {
        if ($this->visualisations->removeElement($visualisation)) {
            // set the owning side to null (unless already changed)
            if ($visualisation->getTenant() === $this) {
                $visualisation->setTenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Theme>
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(Theme $theme): static
    {
        if (!$this->themes->contains($theme)) {
            $this->themes->add($theme);
            $theme->setTenant($this);
        }

        return $this;
    }

    public function removeTheme(Theme $theme): static
    {
        if ($this->themes->removeElement($theme)) {
            // set the owning side to null (unless already changed)
            if ($theme->getTenant() === $this) {
                $theme->setTenant(null);
            }
        }

        return $this;
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
