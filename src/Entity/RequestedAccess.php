<?php

namespace App\Entity;

use App\Repository\RequestedAccessRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequestedAccessRepository::class)]
class RequestedAccess
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $customProfile = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'requestedAccesses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CerbereHabilitation $cerbereHabilitation = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Submission $submission = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomProfile(): ?string
    {
        return $this->customProfile;
    }

    public function setCustomProfile(?string $customProfile): static
    {
        $this->customProfile = $customProfile;
        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;
        return $this;
    }

    public function getCerbereHabilitation(): ?CerbereHabilitation
    {
        return $this->cerbereHabilitation;
    }

    public function setCerbereHabilitation(?CerbereHabilitation $cerbereHabilitation): static
    {
        $this->cerbereHabilitation = $cerbereHabilitation;
        return $this;
    }

    public function getSubmission(): ?Submission
    {
        return $this->submission;
    }

    public function setSubmission(?Submission $submission): static
    {
        $this->submission = $submission;
        return $this;
    }
}
