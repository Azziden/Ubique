<?php

namespace App\Entity;

use App\Repository\PigisteClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PigisteClientRepository::class)]
class PigisteClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 63, nullable: true)]
    private $article;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $signe;

    #[ORM\Column(type: 'float', nullable: true)]
    private $nb_de_feuillet;

    #[ORM\Column(type: 'float', nullable: true)]
    private $forfait;

    #[ORM\Column(type: 'float', nullable: true)]
    private $prix_au_feuillet;

    #[ORM\Column(type: 'float')]
    private $montant;

    #[ORM\Column(type: 'float', nullable: true)]
    private $montant_total_brut;

    #[ORM\Column(type: 'float', nullable: true)]
    private $montant_charge;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\ManyToOne(targetEntity: Magazine::class, inversedBy: 'pigisteClients')]
    private $magazine;

    #[ORM\ManyToOne(targetEntity: SalarieEtEntreprise::class, inversedBy: 'pigisteClients')]
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

    public function getSigne(): ?int
    {
        return $this->signe;
    }

    public function setSigne(?int $signe): self
    {
        $this->signe = $signe;

        return $this;
    }

    public function getNbDeFeuillet(): ?float
    {
        return $this->nb_de_feuillet;
    }

    public function setNbDeFeuillet(?float $nb_de_feuillet): self
    {
        $this->nb_de_feuillet = $nb_de_feuillet;

        return $this;
    }

    public function getForfait(): ?float
    {
        return $this->forfait;
    }

    public function setForfait(?float $forfait): self
    {
        $this->forfait = $forfait;

        return $this;
    }

    public function getPrixAuFeuillet(): ?float
    {
        return $this->prix_au_feuillet;
    }

    public function setPrixAuFeuillet(?float $prix_au_feuillet): self
    {
        $this->prix_au_feuillet = $prix_au_feuillet;

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

    public function getMontantTotalBrut(): ?float
    {
        return $this->montant_total_brut;
    }

    public function setMontantTotalBrut(?float $montant_total_brut): self
    {
        $this->montant_total_brut = $montant_total_brut;

        return $this;
    }

    public function getMontantCharge(): ?float
    {
        return $this->montant_charge;
    }

    public function setMontantCharge(?float $montant_charge): self
    {
        $this->montant_charge = $montant_charge;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

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

    // SalarieEtEntreprise attributes for Dashboard and PigisteClient view

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
