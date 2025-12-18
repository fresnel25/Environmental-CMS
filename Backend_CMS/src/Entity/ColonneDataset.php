<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\ColonneDatasetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColonneDatasetRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(operations: [
    new GetCollection(security: "is_granted('ROLE_FOURNISSEUR_DONNEES') or is_granted('ROLE_ADMINISTRATEUR')"),
    new Get(security: "is_granted('ROLE_FOURNISSEUR_DONNEES') or is_granted('ROLE_ADMINISTRATEUR')"),
    new Post(securityPostDenormalize: "
        is_granted('ROLE_FOURNISSEUR_DONNEES') 
        or is_granted('ROLE_ADMINISTRATEUR')
    "),
    new Patch(security: "is_granted('ROLE_FOURNISSEUR_DONNEES') or is_granted('ROLE_ADMINISTRATEUR')"),
    new Delete(security: "is_granted('ROLE_ADMINISTRATEUR')")
])]
class ColonneDataset extends AbstractTenantEntity implements TenantAwareInterface
{

    #[ORM\Column(length: 255)]
    private ?string $nom_colonne = null;

    #[ORM\Column(length: 255)]
    private ?string $type_colonne = null;

    #[ORM\ManyToOne(inversedBy: 'colonnes')]
    private ?Dataset $dataset = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomColonne(): ?string
    {
        return $this->nom_colonne;
    }

    public function setNomColonne(string $nom_colonne): static
    {
        $this->nom_colonne = $nom_colonne;

        return $this;
    }

    public function getTypeColonne(): ?string
    {
        return $this->type_colonne;
    }

    public function setTypeColonne(string $type_colonne): static
    {
        $this->type_colonne = $type_colonne;

        return $this;
    }

    public function getDataset(): ?Dataset
    {
        return $this->dataset;
    }

    public function setDataset(?Dataset $dataset): static
    {
        $this->dataset = $dataset;

        return $this;
    }
}
