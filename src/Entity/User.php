<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use DateTimeImmutable;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct()
    {
        $this->roles = [];
        $this->submissionsAsAgent = new ArrayCollection();
        $this->submissionsAsFilledBy = new ArrayCollection();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $password = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $zipCode = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $country = null;


    #[ORM\Column(length: 20, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isActive = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isVerified = false;

    #[ORM\Column(type: 'json')]
    private array $roles;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Role $role = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Service $service = null;

    #[ORM\OneToMany(targetEntity: Submission::class, mappedBy: 'agent')]
    private Collection $submissionsAsAgent;

    #[ORM\OneToMany(targetEntity: Submission::class, mappedBy: 'filledBy')]
    private Collection $submissionsAsFilledBy;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $jobTitle = null;

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new DateTimeImmutable();
        }
    }

    public function getId(): ?int { return $this->id; }

    public function getFirstName(): ?string { return $this->firstName; }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string { return $this->lastName; }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getFullName(): string
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    public function __toString(): string
    {
        return $this->getFullName();
    }

    public function getEmail(): ?string { return $this->email; }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string { return $this->password; }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getPhoneNumber(): ?string { return $this->phoneNumber; }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getAddress(): ?string { return $this->address; }

    public function setAddress(?string $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function getCity(): ?string { return $this->city; }

    public function setCity(?string $city): static
    {
        $this->city = $city;
        return $this;
    }

    public function getZipCode(): ?string { return $this->zipCode; }

    public function setZipCode(?string $zipCode): static
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    public function getCountry(): ?string { return $this->country; }

    public function setCountry(?string $country): static
    {
        $this->country = $country;
        return $this;
    }

    public function getStatus(): ?string { return $this->status; }

    public function setStatus(?string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getCategory(): ?string { return $this->category; }

    public function setCategory(?string $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable { return $this->createdAt; }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function isActive(): bool { return $this->isActive; }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function isVerified(): bool { return $this->isVerified; }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(?array $roles): static
    {
        $this->roles = $roles ?? [];
        return $this;
    }

    public function eraseCredentials(): void {}

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRole(): ?Role { return $this->role; }

    public function setRole(?Role $role): static
    {
        $this->role = $role;
        return $this;
    }

    public function getService(): ?Service { return $this->service; }

    public function setService(?Service $service): static
    {
        $this->service = $service;
        return $this;
    }

    public function getSubmissionsAsAgent(): Collection { return $this->submissionsAsAgent; }

    public function addSubmissionAsAgent(Submission $submission): static
    {
        if (!$this->submissionsAsAgent->contains($submission)) {
            $this->submissionsAsAgent[] = $submission;
            $submission->setAgent($this);
        }
        return $this;
    }

    public function removeSubmissionAsAgent(Submission $submission): static
    {
        if ($this->submissionsAsAgent->removeElement($submission)) {
            if ($submission->getAgent() === $this) {
                $submission->setAgent(null);
            }
        }
        return $this;
    }

    public function getSubmissionsAsFilledBy(): Collection { return $this->submissionsAsFilledBy; }

    public function addSubmissionAsFilledBy(Submission $submission): static
    {
        if (!$this->submissionsAsFilledBy->contains($submission)) {
            $this->submissionsAsFilledBy[] = $submission;
            $submission->setFilledBy($this);
        }
        return $this;
    }

    public function removeSubmissionAsFilledBy(Submission $submission): static
    {
        if ($this->submissionsAsFilledBy->removeElement($submission)) {
            if ($submission->getFilledBy() === $this) {
                $submission->setFilledBy(null);
            }
        }
        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(?string $jobTitle): static
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }
}
