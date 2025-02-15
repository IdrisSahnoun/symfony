<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: "App\Repository\StageRepository")]
class Stage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le titre ne doit pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le titre ne doit pas dépasser {{ limit }} caractères.")]
    private ?string $titre = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: "La description ne doit pas être vide.")]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'entreprise ne doit pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom de l'entreprise ne doit pas dépasser {{ limit }} caractères.")]
    private ?string $entreprise = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le lieu ne doit pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le lieu ne doit pas dépasser {{ limit }} caractères.")]
    private ?string $lieu = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "La durée ne doit pas être vide.")]
    #[Assert\Positive(message: "La durée doit être un nombre positif.")]
    private ?int $duree = null;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank(message: "La date de début ne doit pas être vide.")]
    #[Assert\Date(message: "La date de début doit être une date valide.")]
    private ?string $dateDebut = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'stages')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "La catégorie ne doit pas être vide.")]
    private ?Categorie $categorie = null;

    // Getters and setters for each property
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(string $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateDebut(): ?string
    {
        return $this->dateDebut;
    }

    public function setDateDebut(string $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}