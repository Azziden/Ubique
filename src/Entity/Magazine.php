<?php

namespace App\Entity;

use App\Entity\Redachef;
use App\Entity\Iconographique;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MagazineRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


#[ORM\Entity(repositoryClass: MagazineRepository::class)]
/**  @ORM\Table(name="magazine", indexes={@ORM\Index(columns={"code_affaire", "code_affaire_en_clair"}, flags={"fulltext"})}) */

class Magazine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 63)]
    private $code_affaire;

    #[ORM\Column(type: 'string', length: 255)]
    private $code_affaire_en_clair;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $date_de_bouclage;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $date_de_parution;

    #[ORM\Column(type: 'string', length: 127, nullable: true)]
    private $titre_en_clair;

    #[ORM\OneToMany(mappedBy: 'magazine', targetEntity: Iconographique::class)]
    private $iconographiques;

    #[ORM\OneToMany(mappedBy: 'magazine', targetEntity: Redachef::class)]
    private $redachefs;

    #[ORM\Column(type: 'float', length: 63, nullable: true)]
    private $nb_de_page_redactionnelle;

    #[ORM\ManyToOne(targetEntity: Titre::class, inversedBy: 'magazines')]
    #[ORM\JoinColumn(nullable: true)]
    private $titre;

    

    public function __construct()
    {
        $this->redachefs = new ArrayCollection();
        $this->iconographiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeAffaire(): ?string
    {
        return $this->code_affaire;
    }

    public function setCodeAffaire(string $code_affaire): self
    {
        $this->code_affaire = $code_affaire;

        return $this;
    }

    public function getCodeAffaireEnClair(): ?string
    {
        return $this->code_affaire_en_clair;
    }

    public function setCodeAffaireEnClair(string $code_affaire_en_clair): self
    {
        $this->code_affaire_en_clair = $code_affaire_en_clair;

        return $this;
    }

    public function getDateDeBouclage(): ?string
    {
        return $this->date_de_bouclage;
    }

    public function setDateDeBouclage(?string $date_de_bouclage): self
    {
        $this->date_de_bouclage = $date_de_bouclage;

        return $this;
    }

    public function getDateDeParution(): ?string
    {
        return $this->date_de_parution;
    }

    public function setDateDeParution(?string $date_de_parution): self
    {
        $this->date_de_parution = $date_de_parution;

        return $this;
    }

    public function getTitreEnClair(): ?string
    {
        return $this->titre_en_clair;
    }

    public function setTitreEnClair(?string $titre_en_clair): self
    {
        $this->titre_en_clair = $titre_en_clair;

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
            $redachef->setMagazine($this);
        }

        return $this;
    }

    public function removeRedachef(Redachef $redachef): self
    {
        if ($this->redachefs->removeElement($redachef)) {
            // set the owning side to null (unless already changed)
            if ($redachef->getMagazine() === $this) {
                $redachef->setMagazine(null);
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
            $iconographique->setMagazine($this);
        }

        return $this;
    }

    public function removeIconographique(Iconographique $iconographique): self
    {
        if ($this->iconographiques->removeElement($iconographique)) {
            // set the owning side to null (unless already changed)
            if ($iconographique->getMagazine() === $this) {
                $iconographique->setMagazine(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of nb_de_page_redactionnelle
     */ 
    public function getNbDePageRedactionnelle() : ?float
    {
        return $this->nb_de_page_redactionnelle;
    }

    /**
     * Set the value of nb_de_page_redactionnelle
     *
     * @return  self
     */ 
    public function setNbDePageRedactionnelle(?float $nb_de_page_redactionnelle): self
    {
        $this->nb_de_page_redactionnelle = $nb_de_page_redactionnelle;

        return $this;
    }

    public function getTitre(): ?Titre
    {
        return $this->titre;
    }

    public function setTitre(?Titre $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getRacine(): ?string {
        return $this->getTitre()?->getRacine();
    }

    public function __toString(): string {
        return "[" . $this->code_affaire . "] " . $this->code_affaire_en_clair;
    }

}
