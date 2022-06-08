<?php

namespace App\Entity;

use App\Repository\MagazineRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


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
}
