<?php

namespace App\Entity;

use App\Repository\NavigationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NavigationRepository::class)
 */
class Navigation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\OneToMany(targetEntity=NavigationListe::class, mappedBy="navigation")
     */
    private $navigationListes;

    public function __construct()
    {
        $this->navigationListes = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
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
     * @return Collection|NavigationListe[]
     */
    public function getNavigationListes(): Collection
    {
        return $this->navigationListes;
    }

    public function addNavigationListe(NavigationListe $navigationListe): self
    {
        if (!$this->navigationListes->contains($navigationListe)) {
            $this->navigationListes[] = $navigationListe;
            $navigationListe->setNavigation($this);
        }

        return $this;
    }

    public function removeNavigationListe(NavigationListe $navigationListe): self
    {
        if ($this->navigationListes->removeElement($navigationListe)) {
            // set the owning side to null (unless already changed)
            if ($navigationListe->getNavigation() === $this) {
                $navigationListe->setNavigation(null);
            }
        }

        return $this;
    }

   
}
