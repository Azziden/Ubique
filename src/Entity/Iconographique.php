<?php

namespace App\Entity;

use App\Repository\IconographiqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IconographiqueRepository::class)]
class Iconographique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 127, nullable: true)]
    private $article;

    #[ORM\Column(type: 'integer')]
    private $nb_photo;

    #[ORM\Column(type: 'integer')]
    private $prix_photo;

    #[ORM\Column(type: 'float')]
    private $montant;

    #[ORM\ManyToOne(targetEntity: magazine::class, inversedBy: 'iconographiques')]
    #[ORM\JoinColumn(nullable: false)]
    private $magazine;

    #[ORM\OneToOne(inversedBy: 'iconographique', targetEntity: SalarieEtEntreprise::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $salarie_et_entreprise;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?string
    {
        return $this->article;
    }

    public function setArticle(?string $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getNbPhoto(): ?int
    {
        return $this->nb_photo;
    }

    public function setNbPhoto(int $nb_photo): self
    {
        $this->nb_photo = $nb_photo;

        return $this;
    }

    public function getPrixPhoto(): ?int
    {
        return $this->prix_photo;
    }

    public function setPrixPhoto(int $prix_photo): self
    {
        $this->prix_photo = $prix_photo;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMagazine(): ?magazine
    {
        return $this->magazine;
    }

    public function setMagazine(?magazine $magazine): self
    {
        $this->magazine = $magazine;

        return $this;
    }

    public function getSalarieEtEntreprise(): ?SalarieEtEntreprise
    {
        return $this->salarie_et_entreprise;
    }

    public function setSalarieEtEntreprise(SalarieEtEntreprise $salarie_et_entreprise): self
    {
        $this->salarie_et_entreprise = $salarie_et_entreprise;

        return $this;
    }
}
