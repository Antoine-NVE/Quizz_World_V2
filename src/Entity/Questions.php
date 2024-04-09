<?php

namespace App\Entity;

use App\Repository\QuestionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionsRepository::class)]
class Questions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;

    #[ORM\Column(length: 63)]
    private ?string $answer = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $anecdote = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Questionnaires $questionnaire = null;

    #[ORM\OneToMany(targetEntity: Propositions::class, mappedBy: 'question', orphanRemoval: true, cascade: ['remove'])]
    private Collection $propositions;

    public function __construct()
    {
        $this->propositions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): static
    {
        $this->answer = $answer;

        return $this;
    }

    public function getAnecdote(): ?string
    {
        return $this->anecdote;
    }

    public function setAnecdote(?string $anecdote): static
    {
        $this->anecdote = $anecdote;

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

    /**
     * @return Collection<int, Propositions>
     */
    public function getPropositions(): Collection
    {
        return $this->propositions;
    }

    public function addProposition(Propositions $proposition): static
    {
        if (!$this->propositions->contains($proposition)) {
            $this->propositions->add($proposition);
            $proposition->setQuestion($this);
        }

        return $this;
    }

    public function removeProposition(Propositions $proposition): static
    {
        if ($this->propositions->removeElement($proposition)) {
            // set the owning side to null (unless already changed)
            if ($proposition->getQuestion() === $this) {
                $proposition->setQuestion(null);
            }
        }

        return $this;
    }
}
