<?php

namespace App\Entity;

use App\Repository\CerbereHabilitationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CerbereHabilitationRepository::class)]
#[ORM\Table(name: 'cerbere_habilitation')]
class CerbereHabilitation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $toolName = null;

    #[ORM\Column(length: 255)]
    private ?string $applicationCode = null;

    #[ORM\Column(length: 255)]
    private ?string $profile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $roleLabel = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(
        targetEntity: RequestedAccess::class,
        mappedBy: 'cerbereHabilitation',
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $requestedAccesses;

    public function __construct()
    {
        $this->requestedAccesses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToolName(): ?string
    {
        return $this->toolName;
    }

    public function setToolName(string $toolName): static
    {
        $this->toolName = $toolName;
        return $this;
    }

    public function getApplicationCode(): ?string
    {
        return $this->applicationCode;
    }

    public function setApplicationCode(string $applicationCode): static
    {
        $this->applicationCode = $applicationCode;
        return $this;
    }

    public function getProfile(): ?string
    {
        return $this->profile;
    }

    public function setProfile(string $profile): static
    {
        $this->profile = $profile;
        return $this;
    }

    public function getRoleLabel(): ?string
    {
        return $this->roleLabel;
    }

    public function setRoleLabel(?string $roleLabel): static
    {
        $this->roleLabel = $roleLabel;
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

    /**
     * @return Collection<int, RequestedAccess>
     */
    public function getRequestedAccesses(): Collection
    {
        return $this->requestedAccesses;
    }

    public function addRequestedAccess(RequestedAccess $access): static
    {
        if (!$this->requestedAccesses->contains($access)) {
            $this->requestedAccesses->add($access);
            $access->setCerbereHabilitation($this);
        }

        return $this;
    }

    public function removeRequestedAccess(RequestedAccess $access): static
    {
        if ($this->requestedAccesses->removeElement($access)) {
            if ($access->getCerbereHabilitation() === $this) {
                $access->setCerbereHabilitation(null);
            }
        }

        return $this;
    }
}
