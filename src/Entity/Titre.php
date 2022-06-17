<?php

namespace App\Entity;

use App\Repository\TitreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TitreRepository::class)]
class Titre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 127)]
    private $titre_dans_tableau_direction;

    #[ORM\Column(type: 'string', length: 63)]
    private $clients;

    #[ORM\OneToMany(mappedBy: 'titre', targetEntity: Magazine::class)]
    private $racine;

    #[ORM\Column(type: 'string', length: 127)]
    private $racine_en_clair;

    public function __construct()
    {
        $this->racine = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreDansTableauDirection(): ?string
    {
        return $this->titre_dans_tableau_direction;
    }

    public function setTitreDansTableauDirection(string $titre_dans_tableau_direction): self
    {
        $this->titre_dans_tableau_direction = $titre_dans_tableau_direction;

        return $this;
    }

    public function getClients(): ?string
    {
        return $this->clients;
    }

    public function setClients(string $clients): self
    {
        $this->clients = $clients;

        return $this;
    }

    /**
     * @return Collection<int, Magazine>
     */
    public function getRacine(): Collection
    {
        return $this->racine;
    }

    public function addRacine(Magazine $racine): self
    {
        if (!$this->racine->contains($racine)) {
            $this->racine[] = $racine;
            $racine->setTitre($this);
        }

        return $this;
    }

    public function removeRacine(Magazine $racine): self
    {
        if ($this->racine->removeElement($racine)) {
            // set the owning side to null (unless already changed)
            if ($racine->getTitre() === $this) {
                $racine->setTitre(null);
            }
        }

        return $this;
    }

    public function getRacineEnClair(): ?string
    {
        return $this->racine_en_clair;
    }

    public function setRacineEnClair(string $racine_en_clair): self
    {
        $this->racine_en_clair = $racine_en_clair;

        return $this;
    }
}
