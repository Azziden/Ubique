<?php

namespace App\Entity;




use App\Entity\Redachef;
use App\Entity\Iconographique;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\SalarieEtEntrepriseRepository;

#[ORM\Entity(repositoryClass: SalarieEtEntrepriseRepository::class)]
class SalarieEtEntreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 127)]
    private $nom_d_usage;

    #[ORM\Column(type: 'string', length: 127)]
    private $nom_compta;

    #[ORM\Column(type: 'string', length: 63)]
    private $statut;

    #[ORM\Column(type: 'string', length: 63)]
    private $type;

    #[ORM\Column(type: 'float', nullable: true)]
    private $droit_auteur;

    #[ORM\Column(type: 'string', length: 63)]
    private $abattement_30;

    #[ORM\OneToMany(mappedBy: 'salarie_et_entreprise', targetEntity: Redachef::class)]
    private $redachefs;

    #[ORM\OneToMany(mappedBy: 'salarie_et_entreprise', targetEntity: Iconographique::class)]
    private $iconographiques;

    public function __construct()
    {
        $this->redachefs = new ArrayCollection();
        $this->iconographiques = new ArrayCollection();
    }

  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDUsage(): ?string
    {
        return $this->nom_d_usage;
    }

    public function setNomDUsage(string $nom_d_usage): self
    {
        $this->nom_d_usage = $nom_d_usage;

        return $this;
    }

    public function getNomCompta(): ?string
    {
        return $this->nom_compta;
    }

    public function setNomCompta(string $nom_compta): self
    {
        $this->nom_compta = $nom_compta;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDroitAuteur(): ?float
    {
        return $this->droit_auteur;
    }

    public function setDroitAuteur(?float $droit_auteur): self
    {
        $this->droit_auteur = $droit_auteur;

        return $this;
    }

    public function getAbattement30(): ?string
    {
        return $this->abattement_30;
    }

    public function setAbattement30(string $abattement_30): self
    {
        $this->abattement_30 = $abattement_30;

        return $this;
    }

    
    public function __toString(): string {
        return $this->getNomDUsage();
    }

    public function getIconographique(): ?Iconographique
    {
        return $this->iconographique;
    }

    public function setIconographique(?Iconographique $iconographique): self
    {
        $this->iconographique = $iconographique;

        return $this;
    }

    public function getRedachef(): ?Redachef
    {
        return $this->redachef;
    }

    public function setRedachef(?Redachef $redachef): self
    {
        $this->redachef = $redachef;

        return $this;
    }

    /**
     * @return Collection<int, Redachef>
     */
    public function getRedachefs(): Collection
    {
        return $this->redachefs;
    }

    public function addRedachef(Redachef $redachef): self
    {
        if (!$this->redachefs->contains($redachef)) {
            $this->redachefs[] = $redachef;
            $redachef->setSalarieEtEntreprise($this);
        }

        return $this;
    }

    public function removeRedachef(Redachef $redachef): self
    {
        if ($this->redachefs->removeElement($redachef)) {
            // set the owning side to null (unless already changed)
            if ($redachef->getSalarieEtEntreprise() === $this) {
                $redachef->setSalarieEtEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Iconographique>
     */
    public function getIconographiques(): Collection
    {
        return $this->iconographiques;
    }

    public function addIconographique(Iconographique $iconographique): self
    {
        if (!$this->iconographiques->contains($iconographique)) {
            $this->iconographiques[] = $iconographique;
            $iconographique->setSalarieEtEntreprise($this);
        }

        return $this;
    }

    public function removeIconographique(Iconographique $iconographique): self
    {
        if ($this->iconographiques->removeElement($iconographique)) {
            // set the owning side to null (unless already changed)
            if ($iconographique->getSalarieEtEntreprise() === $this) {
                $iconographique->setSalarieEtEntreprise(null);
            }
        }

        return $this;
    }
    
}
