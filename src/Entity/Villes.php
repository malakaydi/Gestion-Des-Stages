<?php

namespace App\Entity;

use App\Repository\VillesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VillesRepository::class)
 */
class Villes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    
    /**
     * @ORM\ManyToOne(targetEntity=Departements::class, inversedBy="villes")
     * @ORM\JoinColumn( name="departement_id",nullable=false)
     */
    private $departements;

    /**
     * @ORM\OneToMany(targetEntity=Membres::class, mappedBy="ville_id")
     */
    private $membres;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
    }

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

  

    public function getDepartements(): ?Departements
    {
        return $this->departements;
    }

    public function setDepartements(?Departements $departements): self
    {
        $this->departements = $departements;

        return $this;
    }

    /**
     * @return Collection|Membres[]
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membres $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres[] = $membre;
            $membre->setVilleId($this);
        }

        return $this;
    }

    public function removeMembre(Membres $membre): self
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getVilleId() === $this) {
                $membre->setVilleId(null);
            }
        }

        return $this;
    }
}
