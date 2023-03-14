<?php

namespace App\Entity;

use App\Repository\InformationBoardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InformationBoardRepository::class)]
class InformationBoard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $date_create = null;

    #[ORM\Column]
    private ?int $id_creator = null;

    #[ORM\Column]
    private ?int $id_group = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCreate(): ?string
    {
        return $this->date_create;
    }

    public function setDateCreate(string $date_create): self
    {
        $this->date_create = $date_create;

        return $this;
    }

    public function getIdCreator(): ?int
    {
        return $this->id_creator;
    }

    public function setIdCreator(int $id_creator): self
    {
        $this->id_creator = $id_creator;

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
}
