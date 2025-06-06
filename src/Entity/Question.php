<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?bool $required = null;

    #[ORM\Column(nullable: true)]
    private ?int $orderIndex = null;

    #[ORM\Column(length: 255)]
    private ?string $submissionType = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: "depends_on_question_id", referencedColumnName: "id", nullable: true)]
    private ?self $dependsOnQuestion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dependsOnValue = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function isRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): static
    {
        $this->required = $required;
        return $this;
    }

    public function getOrderIndex(): ?int
    {
        return $this->orderIndex;
    }

    public function setOrderIndex(?int $orderIndex): static
    {
        $this->orderIndex = $orderIndex;
        return $this;
    }

    public function getSubmissionType(): ?string
    {
        return $this->submissionType;
    }

    public function setSubmissionType(string $submissionType): static
    {
        $this->submissionType = $submissionType;
        return $this;
    }

    public function getDependsOnQuestion(): ?self
    {
        return $this->dependsOnQuestion;
    }

    public function setDependsOnQuestion(?self $dependsOnQuestion): static
    {
        $this->dependsOnQuestion = $dependsOnQuestion;
        return $this;
    }

    public function getDependsOnValue(): ?string
    {
        return $this->dependsOnValue;
    }

    public function setDependsOnValue(?string $dependsOnValue): static
    {
        $this->dependsOnValue = $dependsOnValue;
        return $this;
    }
}
