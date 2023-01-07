<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $filliere = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $keyword1 = null;

    #[ORM\Column(length: 255)]
    private ?string $keyword2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $keyword3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $keyword4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $keyword5 = null;

    #[ORM\Column]
    private $file=null;

    #[ORM\Column(nullable: true)]
    private ?bool $valide = null;

    #[ORM\ManyToOne(inversedBy: 'documents')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFilliere(): ?string
    {
        return $this->filliere;
    }

    public function setFilliere(string $filliere): self
    {
        $this->filliere = $filliere;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

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

    public function getKeyword1(): ?string
    {
        return $this->keyword1;
    }

    public function setKeyword1(string $keyword1): self
    {
        $this->keyword1 = $keyword1;

        return $this;
    }

    public function getKeyword2(): ?string
    {
        return $this->keyword2;
    }

    public function setKeyword2(string $keyword2): self
    {
        $this->keyword2 = $keyword2;

        return $this;
    }

    public function getKeyword3(): ?string
    {
        return $this->keyword3;
    }

    public function setKeyword3(?string $keyword3): self
    {
        $this->keyword3 = $keyword3;

        return $this;
    }

    public function getKeyword4(): ?string
    {
        return $this->keyword4;
    }

    public function setKeyword4(?string $keyword4): self
    {
        $this->keyword4 = $keyword4;

        return $this;
    }

    public function getKeyword5(): ?string
    {
        return $this->keyword5;
    }

    public function setKeyword5(?string $keyword5): self
    {
        $this->keyword5 = $keyword5;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file): self
    {
        $this->file = $file;

        return $this;
    }

    public function isValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(?bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
