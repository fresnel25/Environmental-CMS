<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Processor\BlocProcessor;
use App\Repository\BlocRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlocRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(operations: [
    new GetCollection(security: "is_granted('PUBLIC_ACCESS')"),
    new Get(security: "is_granted('TENANT_VIEW', object)"),
    new Post(processor: BlocProcessor::class, securityPostDenormalize: "
        is_granted('ROLE_AUTEUR') 
        or is_granted('ROLE_EDITEUR') 
        or is_granted('ROLE_ADMINISTRATEUR')
    "),
    new Patch(processor: BlocProcessor::class, security: "
        is_granted('TENANT_EDIT', object) 
        and (is_granted('ROLE_AUTEUR') and object.getCreatedBy() == user
             or is_granted('ROLE_EDITEUR') 
             or is_granted('ROLE_ADMINISTRATEUR'))
    "),
    new Delete(security: "is_granted('TENANT_DELETE', object) and is_granted('ROLE_ADMINISTRATEUR')")
])]
class Bloc extends AbstractTenantEntity implements TenantAwareInterface
{

    #[ORM\Column(length: 255)]
    private ?string $type_bloc = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column(type: 'json')]
    private array $contenu_json = [];

    #[ORM\ManyToOne(inversedBy: 'blocs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Article $article = null;

    #[ORM\OneToOne(inversedBy: 'bloc', cascade: ['persist', 'remove'])]
    private ?Visualisation $visualisation = null;


    #[ORM\ManyToOne()]
    private ?Media $media = null;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'bloc')]
    private Collection $notes;




    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeBloc(): ?string
    {
        return $this->type_bloc;
    }

    public function setTypeBloc(string $type_bloc): static
    {
        $this->type_bloc = $type_bloc;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getContenuJson(): array
    {
        return $this->contenu_json;
    }

    public function setContenuJson(array $contenu_json): static
    {
        $this->contenu_json = $contenu_json;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getVisualisation(): ?Visualisation
    {
        return $this->visualisation;
    }

    public function setVisualisation(?Visualisation $visualisation): static
    {
        $this->visualisation = $visualisation;

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
            $note->setBloc($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getBloc() === $this) {
                $note->setBloc(null);
            }
        }

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): static
    {
        $this->media = $media;

        return $this;
    }
}
