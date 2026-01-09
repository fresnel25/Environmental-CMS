<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(operations: [
    new GetCollection(security: "is_granted('PUBLIC_ACCESS')"),
    new Get(security: "is_granted('PUBLIC_ACCESS')"),
    new Post(securityPostDenormalize: "is_granted('ROLE_ABONNE') or is_granted('ROLE_ADMINISTRATEUR')"),
    new Patch(security: "
        is_granted('ROLE_ABONNE') and object.getCreatedBy() == user 
        or is_granted('ROLE_ADMINISTRATEUR')
    "),
    new Delete(security: "is_granted('ROLE_ADMINISTRATEUR')")
])]
class Note extends AbstractTenantEntity implements TenantAwareInterface
{

    #[ORM\Column(nullable: true)]
    private ?int $valeur = null;

    #[ORM\ManyToOne(inversedBy: 'notes')]
    private ?Bloc $bloc = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    public function setValeur(?int $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getBloc(): ?Bloc
    {
        return $this->bloc;
    }

    public function setBloc(?Bloc $bloc): static
    {
        $this->bloc = $bloc;

        return $this;
    }
}
