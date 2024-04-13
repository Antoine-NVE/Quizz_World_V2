<?php

namespace App\Entity;

use App\Repository\PropositionsRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

#[ORM\Entity(repositoryClass: PropositionsRepository::class)]
#[UniqueConstraint(columns: ['question_id', 'proposition'])]
class Propositions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 63)]
    private ?string $proposition = null;

    #[ORM\ManyToOne(inversedBy: 'propositions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Questions $question = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProposition(): ?string
    {
        return $this->proposition;
    }

    public function setProposition(string $proposition): static
    {
        $this->proposition = $proposition;

        return $this;
    }

    public function getQuestion(): ?Questions
    {
        return $this->question;
    }

    public function setQuestion(?Questions $question): static
    {
        $this->question = $question;

        return $this;
    }
}
