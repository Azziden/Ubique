<?php

namespace App\Entity;

use App\Entity\Magazine;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\SalarieEtEntreprise;
use App\Repository\IconographiqueRepository;

#[ORM\Entity(repositoryClass: IconographiqueRepository::class)]
class Iconographique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 127, nullable: true)]
    private $article;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nb_photo;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $prix_photo;

    #[ORM\Column(type: 'float')]
    private $montant;

    #[ORM\ManyToOne(targetEntity: Magazine::class, inversedBy: 'iconographiques')]
    private $magazine;

    #[ORM\ManyToOne(targetEntity: SalarieEtEntreprise::class, inversedBy: 'iconographiques')]
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

    public function setNbPhoto(?int $nb_photo): self
    {
        $this->nb_photo = $nb_photo;

        return $this;
    }

    public function getPrixPhoto(): ?int
    {
        return $this->prix_photo;
    }

    public function setPrixPhoto(?int $prix_photo): self
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

    public function getMagazine(): ?Magazine
    {
        return $this->magazine;
    }

    public function setMagazine(?Magazine $magazine): self
    {
        $this->magazine = $magazine;

        return $this;
    }

    public function getSalarieEtEntreprise(): ?SalarieEtEntreprise
    {
        return $this->salarie_et_entreprise;
    }

    public function setSalarieEtEntreprise(?SalarieEtEntreprise $salarie_et_entreprise): self
    {
        $this->salarie_et_entreprise = $salarie_et_entreprise;

        return $this;
    }
    // SalarieEtEntreprise attributes for Dashboard and Iconographique view

    public function getNomDUsage(): string {
        return $this->getSalarieEtEntreprise()->getNomDUsage();
    }

    public function getNomCompta(): string {
        return $this->getSalarieEtEntreprise()->getNomCompta();
    }

    public function getStatut(): string {
        return $this->getSalarieEtEntreprise()->getStatut();
    }

    public function getType(): string {
        return $this->getSalarieEtEntreprise()->getType();
    }

    public function getCodeAffaire(): string {
        return $this->getMagazine()->getCodeAffaire();
    }

    public function getRacine(): ?string {
        return $this->getMagazine()->getTitre()?->getRacine();
    }
}
