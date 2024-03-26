<?php

namespace App\Entity;

use App\Repository\ScoresRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScoresRepository::class)]
class Scores
{
    #[ORM\Column]
    private ?int $score = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'scores')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Questionnaires $questionnaire = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'scores')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getQuestionnaire(): ?Questionnaires
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(?Questionnaires $questionnaire): static
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }
}
