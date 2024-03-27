<?php

namespace App\Entity;

use App\Repository\ListeOffresRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListeOffresRepository::class)
 */
class ListeOffres
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Membres::class, inversedBy="categories")
     */
    private $membres;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="listeOffres" )
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity=Fonctions::class, inversedBy="listeOffres" )
     */
    private $fonctions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $langue_offres;

    /**
     * @ORM\Column(type="integer",nullable=false)
     */
    private $nombre_stagiaire;

    /**
     * @ORM\ManyToOne(targetEntity=Departements::class, inversedBy="listeOffres" )
     */
    private $departements;

    /**
     * @ORM\ManyToOne(targetEntity=Villes::class, inversedBy="listeOffres")
     */
    private $villes;

    /**
     * @ORM\Column(type="date")
     */
    private $date_debut_stage;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin_stage;

    /**
     * @ORM\Column(type="date" )
     */
    private $date_inscri;

    /**
     * @ORM\Column(type="string", length=255 ,nullable=false)
     */
    private $type_contrat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Remuneration;

     /**
     * @ORM\Column(type="text" ,nullable=false)
     */
    private $description_offres;

    /**
     * @ORM\Column(type="string", length=255 ,nullable=false)
     */
    private $niveau_etude;

    /**
     * @ORM\Column(type="string", length=255 ,nullable=false)
     */
    private $formations_requises;

    /**
     * @ORM\Column(type="boolean")
     */
    private $permis;

     /**
     * @ORM\Column(type="text" ,nullable=false)
     */
    private $competences;

      /**
     * @ORM\Column(type="text" ,nullable=false)
     */
    private $langue_parlee;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    /**
     * @ORM\Column(type="boolean")
     */
    private $a_la_une;

    /**
     * @ORM\Column(type="date")
     */
    private $date_depo;

    /**
     * @ORM\Column(type="date",nullable=false)
     */
    private $date_fin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMembres(): ?membres
    {
        return $this->membres;
    }

    public function setMembres(?membres $membres): self
    {
        $this->membres = $membres;

        return $this;
    }

    public function getCategories(): ?categories
    {
        return $this->categories;
    }

    public function setCategories(?categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getFonctions(): ?fonctions
    {
        return $this->fonctions;
    }

    public function setFonctions(?fonctions $fonctions): self
    {
        $this->fonctions = $fonctions;

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

    public function getLangueOffres(): ?string
    {
        return $this->langue_offres;
    }

    public function setLangueOffres(string $langue_offres): self
    {
        $this->langue_offres = $langue_offres;

        return $this;
    }

    public function getNombreStagiaire(): ?int
    {
        return $this->nombre_stagiaire;
    }

    public function setNombreStagiaire(int $nombre_stagiaire): self
    {
        $this->nombre_stagiaire = $nombre_stagiaire;

        return $this;
    }

    public function getDepartements(): ?departements
    {
        return $this->departements;
    }

    public function setDepartements(?departements $departements): self
    {
        $this->departements = $departements;

        return $this;
    }

    public function getVilles(): ?villes
    {
        return $this->villes;
    }

    public function setVilles(?villes $villes): self
    {
        $this->villes = $villes;

        return $this;
    }

    public function getDateDebutStage(): ?\DateTimeInterface
    {
        return $this->date_debut_stage;
    }

    public function setDateDebutStage(\DateTimeInterface $date_debut_stage): self
    {
        $this->date_debut_stage = $date_debut_stage;

        return $this;
    }

    public function getDateFinStage(): ?\DateTimeInterface
    {
        return $this->date_fin_stage;
    }

    public function setDateFinStage(\DateTimeInterface $date_fin_stage): self
    {
        $this->date_fin_stage = $date_fin_stage;

        return $this;
    }

    public function getDateInscri(): ?\DateTimeInterface
    {
        return $this->date_inscri;
    }

    public function setDateInscri(\DateTimeInterface $date_inscri): self
    {
        $this->date_inscri = $date_inscri;

        return $this;
    }

    public function getTypeContrat(): ?string
    {
        return $this->type_contrat;
    }

    public function setTypeContrat(string $type_contrat): self
    {
        $this->type_contrat = $type_contrat;

        return $this;
    }

    public function getRemuneration(): ?string
    {
        return $this->Remuneration;
    }

    public function setRemuneration(string $Remuneration): self
    {
        $this->Remuneration = $Remuneration;

        return $this;
    }

    public function getDescriptionOffres(): ?string
    {
        return $this->description_offres;
    }

    public function setDescriptionOffres(string $description_offres): self
    {
        $this->description_offres = $description_offres;

        return $this;
    }

    public function getNiveauEtude(): ?string
    {
        return $this->niveau_etude;
    }

    public function setNiveauEtude(string $niveau_etude): self
    {
        $this->niveau_etude = $niveau_etude;

        return $this;
    }

    public function getFormationsRequises(): ?string
    {
        return $this->formations_requises;
    }

    public function setFormationsRequises(string $formations_requises): self
    {
        $this->formations_requises = $formations_requises;

        return $this;
    }

    public function getPermis(): ?bool
    {
        return $this->permis;
    }

    public function setPermis(bool $permis): self
    {
        $this->permis = $permis;

        return $this;
    }

    public function getCompetences(): ?string
    {
        return $this->competences;
    }

    public function setCompetences(string $competences): self
    {
        $this->competences = $competences;

        return $this;
    }

    public function getLangueParlee(): ?string
    {
        return $this->langue_parlee;
    }

    public function setLangueParlee(string $langue_parlee): self
    {
        $this->langue_parlee = $langue_parlee;

        return $this;
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

    public function getALaUne(): ?bool
    {
        return $this->a_la_une;
    }

    public function setALaUne(bool $a_la_une): self
    {
        $this->a_la_une = $a_la_une;

        return $this;
    }

    public function getDateDepo(): ?\DateTimeInterface
    {
        return $this->date_depo;
    }

    public function setDateDepo(\DateTimeInterface $date_depo): self
    {
        $this->date_depo = $date_depo;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }
}
