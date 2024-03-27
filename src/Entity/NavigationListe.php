<?php

namespace App\Entity;

use App\Repository\NavigationListeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NavigationListeRepository::class)
 */
class NavigationListe
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
     * @ORM\Column(type="string", length=255)
     */
    private $type_de_page;

    /**
     * @ORM\ManyToOne(targetEntity=Navigation::class, inversedBy="navigationListes")
     */
    private $navigation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $target;

    /**
     * @ORM\Column(type="boolean")
     */
    private $no_follow;

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

    public function getTypeDePage(): ?string
    {
        return $this->type_de_page;
    }

    public function setTypeDePage(string $type_de_page): self
    {
        $this->type_de_page = $type_de_page;

        return $this;
    }

    public function getNavigation(): ?navigation
    {
        return $this->navigation;
    }

    public function setNavigation(?navigation $navigation): self
    {
        $this->navigation = $navigation;

        return $this;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(string $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getNoFollow(): ?bool
    {
        return $this->no_follow;
    }

    public function setNoFollow(bool $no_follow): self
    {
        $this->no_follow = $no_follow;

        return $this;
    }
}
