<?php

namespace App\Entity;

use App\Repository\DepartementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepartementsRepository::class)
 */
class Departements
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
     * @ORM\OneToMany(targetEntity=Villes::class, mappedBy="departements", orphanRemoval=true)
     */
    private $villes;

    /**
     * @ORM\OneToMany(targetEntity=Membres::class, mappedBy="departement_id")
     */
    private $membres;

    public function __construct()
    {
        $this->villes = new ArrayCollection();
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

    /**
     * @return Collection|Villes[]
     */
    public function getVilles(): Collection
    {
        return $this->villes;
    }

    public function addVille(Villes $ville): self
    {
        if (!$this->villes->contains($ville)) {
            $this->villes[] = $ville;
            $ville->setDepartements($this);
        }

        return $this;
    }

    public function removeVille(Villes $ville): self
    {
        if ($this->villes->removeElement($ville)) {
            // set the owning side to null (unless already changed)
            if ($ville->getDepartements() === $this) {
                $ville->setDepartements(null);
            }
        }

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
            $membre->setDepartementId($this);
        }

        return $this;
    }

    public function removeMembre(Membres $membre): self
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getDepartementId() === $this) {
                $membre->setDepartementId(null);
            }
        }

        return $this;
    }
}
