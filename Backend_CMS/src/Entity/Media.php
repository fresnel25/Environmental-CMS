<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\MediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(normalizationContext: ['groups' => ['media:read']] ,
    operations: [
    new GetCollection(security: "is_granted('PUBLIC_ACCESS')"),
    new Get(security: "is_granted('PUBLIC_ACCESS')"),
    new Post(securityPostDenormalize: "
        is_granted('ROLE_EDITEUR') 
        or is_granted('ROLE_DESIGNER') 
        or is_granted('ROLE_ADMINISTRATEUR')
    "),
    new Patch(security: "is_granted('ROLE_DESIGNER') or is_granted('ROLE_ADMINISTRATEUR')"),
    new Delete(security: "is_granted('ROLE_ADMINISTRATEUR')")
])]
class Media extends AbstractTenantEntity implements TenantAwareInterface
{   

    #[Groups(['bloc:read', 'media:read'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $lien = null;

    #[Groups(['bloc:read', 'media:read'])]
    #[ORM\Column(length: 255)]
    private ?string $type_img = null;

    #[Groups(['bloc:read', 'media:read'])]
    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    /**
     * @var Collection<int, Bloc>
     */
    #[ORM\OneToMany(targetEntity: Bloc::class, mappedBy: 'media')]
    private Collection $blocs;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): static
    {
        $this->lien = $lien;

        return $this;
    }

    public function getTypeImg(): ?string
    {
        return $this->type_img;
    }

    public function setTypeImg(string $type_img): static
    {
        $this->type_img = $type_img;

        return $this;
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
            $bloc->setMedia($this);
        }

        return $this;
    }

    public function removeBloc(Bloc $bloc): static
    {
        if ($this->blocs->removeElement($bloc)) {
            // set the owning side to null (unless already changed)
            if ($bloc->getMedia() === $this) {
                $bloc->setMedia(null);
            }
        }

        return $this;
    }
}
