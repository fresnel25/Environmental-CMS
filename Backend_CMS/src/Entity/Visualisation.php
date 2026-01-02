<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\VisualisationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisualisationRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(operations: [
    new GetCollection(security: "is_granted('PUBLIC_ACCESS')"),
    new Get(security: "is_granted('PUBLIC_ACCESS')"),
    new Post(securityPostDenormalize: "
        is_granted('ROLE_AUTEUR') 
        or is_granted('ROLE_EDITEUR') 
        or is_granted('ROLE_DATA_PROVIDER') 
        or is_granted('ROLE_ADMINISTRATEUR')
    "),
    new Patch(security: "is_granted('ROLE_DESIGNER') or is_granted('ROLE_ADMINISTRATEUR')"),
    new Delete(security: "is_granted('ROLE_ADMINISTRATEUR')")
])]
class Visualisation extends AbstractTenantEntity implements TenantAwareInterface
{

    #[ORM\Column(length: 255)]
    private ?string $type_visualisation = null;

    #[ORM\Column]
    private array $correspondance_json = [];

    #[ORM\Column(nullable: true)]
    private ?array $style_json = null;

    #[ORM\Column(nullable: true)]
    private ?array $filter_json = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $note = null;

    #[ORM\OneToOne(mappedBy: 'visualisation', cascade: ['persist', 'remove'])]
    private ?Bloc $bloc = null;

    #[ORM\ManyToOne(inversedBy: 'visualisations')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Dataset $dataset = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeVisualisation(): ?string
    {
        return $this->type_visualisation;
    }

    public function setTypeVisualisation(string $type_visualisation): static
    {
        $this->type_visualisation = $type_visualisation;

        return $this;
    }

    public function getCorrespondanceJson(): array
    {
        return $this->correspondance_json;
    }

    public function setCorrespondanceJson(array $correspondance_json): static
    {
        $this->correspondance_json = $correspondance_json;

        return $this;
    }

    public function getStyleJson(): ?array
    {
        return $this->style_json;
    }

    public function setStyleJson(?array $style_json): static
    {
        $this->style_json = $style_json;

        return $this;
    }

    public function getFilterJson(): ?array
    {
        return $this->filter_json;
    }

    public function setFilterJson(?array $filter_json): static
    {
        $this->filter_json = $filter_json;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getBloc(): ?Bloc
    {
        return $this->bloc;
    }

    public function setBloc(?Bloc $bloc): static
    {
        // unset the owning side of the relation if necessary
        if ($bloc === null && $this->bloc !== null) {
            $this->bloc->setVisualisation(null);
        }

        // set the owning side of the relation if necessary
        if ($bloc !== null && $bloc->getVisualisation() !== $this) {
            $bloc->setVisualisation($this);
        }

        $this->bloc = $bloc;

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
