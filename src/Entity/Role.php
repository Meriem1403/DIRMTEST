<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[ORM\Table(name: 'role')]
#[ORM\UniqueConstraint(name: 'UNIQ_ROLE_NAME', columns: ['name'])]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'role')]
    private Collection $users;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $hierarchy = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->hierarchy = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;
        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setRole($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            if ($user->getRole() === $this && method_exists($user, 'setRole')) {
                $user->setRole(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->label ?? $this->name ?? 'Role';
    }

    public function getHierarchy(): array
    {
        return $this->hierarchy ?? [];
    }

    public function setHierarchy(?array $hierarchy): static
    {
        $this->hierarchy = $hierarchy;
        return $this;
    }
}
