<?php

namespace App\Entity;

use App\Repository\VoteLangRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteLangRepository::class)]
class VoteLang
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_vote = null;

    #[ORM\Column]
    private ?int $id_user = null;

    #[ORM\Column]
    private ?int $id_group = null;

    #[ORM\Column(length: 10)]
    private ?string $vote_option = null;

    #[ORM\Column(length: 255)]
    private ?string $date_vote = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdVote(): ?int
    {
        return $this->id_vote;
    }

    public function setIdVote(int $id_vote): self
    {
        $this->id_vote = $id_vote;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdGroup(): ?int
    {
        return $this->id_group;
    }

    public function setIdGroup(int $id_group): self
    {
        $this->id_group = $id_group;

        return $this;
    }

    public function getVoteOption(): ?string
    {
        return $this->vote_option;
    }

    public function setVoteOption(string $vote_option): self
    {
        $this->vote_option = $vote_option;

        return $this;
    }

    public function getDateVote(): ?string
    {
        return $this->date_vote;
    }

    public function setDateVote(string $date_vote): self
    {
        $this->date_vote = $date_vote;

        return $this;
    }
}
