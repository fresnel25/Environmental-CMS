<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource]
class Plan extends AbstractBaseEntity
{

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column]
    private array $limite = [];

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    /**
     * @var Collection<int, Tenant>
     */
    #[ORM\OneToMany(targetEntity: Tenant::class, mappedBy: 'plan')]
    private Collection $tenants;

    public function __construct()
    {
        $this->tenants = new ArrayCollection();
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

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getLimite(): array
    {
        return $this->limite;
    }

    public function setLimite(array $limite): static
    {
        $this->limite = $limite;

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


    /**
     * @return Collection<int, Tenant>
     */
    public function getTenants(): Collection
    {
        return $this->tenants;
    }

  

    
}
