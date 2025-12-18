<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use App\Entity\TenantAwareInterface;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(operations: [
    // Collection publique
    new GetCollection(security: "is_granted('PUBLIC_ACCESS')"),

    // Item : même tenant
    new Get(security: "is_granted('TENANT_VIEW', object)"),

    // Création : rôles auteur/éditeur/admin
    new Post(securityPostDenormalize: "
        is_granted('ROLE_AUTEUR') 
        or is_granted('ROLE_EDITEUR') 
        or is_granted('ROLE_ADMINISTRATEUR')
    "),

    // Modification : tenant + rôle
    new Patch(security: "
        is_granted('TENANT_EDIT', object) 
        and (is_granted('ROLE_AUTEUR') and object.getCreatedBy() == user
             or is_granted('ROLE_EDITEUR') 
             or is_granted('ROLE_ADMINISTRATEUR'))
    "),

    // Suppression : tenant + admin
    new Delete(security: "is_granted('TENANT_DELETE', object) and is_granted('ROLE_ADMINISTRATEUR')")
])]
class Article extends AbstractTenantEntity implements TenantAwareInterface
{

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $resume = null;

    #[ORM\Column(type: 'boolean')]
    private bool $status = false;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie = null;

    /**
     * @var Collection<int, Bloc>
     */
    #[ORM\OneToMany(targetEntity: Bloc::class, mappedBy: 'article', orphanRemoval: true)]
    private Collection $blocs;


    public function __construct()
    {
        $this->blocs = new ArrayCollection();
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

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): static
    {
        $this->resume = $resume;

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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

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
            $bloc->setArticle($this);
        }

        return $this;
    }

    public function removeBloc(Bloc $bloc): static
    {
        if ($this->blocs->removeElement($bloc)) {
            // set the owning side to null (unless already changed)
            if ($bloc->getArticle() === $this) {
                $bloc->setArticle(null);
            }
        }

        return $this;
    }
}
