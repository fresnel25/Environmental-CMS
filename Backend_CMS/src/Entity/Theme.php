<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\ThemeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(operations: [
    new GetCollection(security: "is_granted('PUBLIC_ACCESS')"),
    new Get(security: "is_granted('PUBLIC_ACCESS')"),
    new Post(securityPostDenormalize: "is_granted('ROLE_DESIGNER') or is_granted('ROLE_ADMINISTRATEUR')"),
    new Patch(security: "is_granted('ROLE_DESIGNER') or is_granted('ROLE_ADMINISTRATEUR')"),
    new Delete(security: "is_granted('ROLE_ADMINISTRATEUR')")
])]
class Theme extends AbstractTenantEntity implements TenantAwareInterface
{

    #[ORM\Column(length: 255)]
    private ?string $nom_theme = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private array $variable_css = [];

    #[ORM\Column]
    private ?bool $active = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTheme(): ?string
    {
        return $this->nom_theme;
    }

    public function setNomTheme(string $nom_theme): static
    {
        $this->nom_theme = $nom_theme;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getVariableCss(): array
    {
        return $this->variable_css;
    }

    public function setVariableCss(array $variable_css): static
    {
        $this->variable_css = $variable_css;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }
}
