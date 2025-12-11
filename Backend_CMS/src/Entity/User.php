<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\UserController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(operations: [
    new Post(
        name: 'register',
        uriTemplate: '/register',
        controller: UserController::class,
        security: "is_granted('PUBLIC_ACCESS')"
    ),
    new \ApiPlatform\Metadata\GetCollection(
        security: "is_granted('ROLE_ADMIN')"
    ),
    new \ApiPlatform\Metadata\Get(
        security: "is_granted('ROLE_ADMIN') or object == user"
    ),
    new \ApiPlatform\Metadata\Put(
        security: "is_granted('ROLE_ADMIN') or object == user"
    ),
    new \ApiPlatform\Metadata\Delete(
        security: "is_granted('ROLE_ADMIN')"
    )
])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Tenant $tenant = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $statut = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone;


    /**
     * @var Collection<int, Article>
     */
    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'created_by')]
    private Collection $articles;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'user')]
    private Collection $notes;

    /**
     * @var Collection<int, Bloc>
     */
    #[ORM\OneToMany(targetEntity: Bloc::class, mappedBy: 'created_by')]
    private Collection $blocs;

    /**
     * @var Collection<int, Media>
     */
    #[ORM\OneToMany(targetEntity: Media::class, mappedBy: 'uploaded_by')]
    private Collection $media;

    /**
     * @var Collection<int, ColonneDataset>
     */
    #[ORM\OneToMany(targetEntity: ColonneDataset::class, mappedBy: 'created_by')]
    private Collection $colonneDatasets;

    /**
     * @var Collection<int, Dataset>
     */
    #[ORM\OneToMany(targetEntity: Dataset::class, mappedBy: 'created_by')]
    private Collection $datasets;

    /**
     * @var Collection<int, Visualisation>
     */
    #[ORM\OneToMany(targetEntity: Visualisation::class, mappedBy: 'created_by')]
    private Collection $visualisations;

    /**
     * @var Collection<int, Theme>
     */
    #[ORM\OneToMany(targetEntity: Theme::class, mappedBy: 'created_by')]
    private Collection $themes;


    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

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

    public function __construct()
    {
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

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
            $article->setCreatedBy($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCreatedBy() === $this) {
                $article->setCreatedBy(null);
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
            $note->setUser($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getUser() === $this) {
                $note->setUser(null);
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
            $bloc->setCreatedBy($this);
        }

        return $this;
    }

    public function removeBloc(Bloc $bloc): static
    {
        if ($this->blocs->removeElement($bloc)) {
            // set the owning side to null (unless already changed)
            if ($bloc->getCreatedBy() === $this) {
                $bloc->setCreatedBy(null);
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
            $medium->setUploadedBy($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): static
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getUploadedBy() === $this) {
                $medium->setUploadedBy(null);
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
            $colonneDataset->setCreatedBy($this);
        }

        return $this;
    }

    public function removeColonneDataset(ColonneDataset $colonneDataset): static
    {
        if ($this->colonneDatasets->removeElement($colonneDataset)) {
            // set the owning side to null (unless already changed)
            if ($colonneDataset->getCreatedBy() === $this) {
                $colonneDataset->setCreatedBy(null);
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
            $dataset->setCreatedBy($this);
        }

        return $this;
    }

    public function removeDataset(Dataset $dataset): static
    {
        if ($this->datasets->removeElement($dataset)) {
            // set the owning side to null (unless already changed)
            if ($dataset->getCreatedBy() === $this) {
                $dataset->setCreatedBy(null);
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
            $visualisation->setCreatedBy($this);
        }

        return $this;
    }

    public function removeVisualisation(Visualisation $visualisation): static
    {
        if ($this->visualisations->removeElement($visualisation)) {
            // set the owning side to null (unless already changed)
            if ($visualisation->getCreatedBy() === $this) {
                $visualisation->setCreatedBy(null);
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
            $theme->setCreatedBy($this);
        }

        return $this;
    }

    public function removeTheme(Theme $theme): static
    {
        if ($this->themes->removeElement($theme)) {
            // set the owning side to null (unless already changed)
            if ($theme->getCreatedBy() === $this) {
                $theme->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

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
