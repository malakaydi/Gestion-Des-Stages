<?php

namespace App\Entity;

use App\Repository\MembresRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MembresRepository::class)
 */
class Membres implements PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="membres")
     *  @ORM\JoinColumn( name="category_id",nullable=true)
     */
    private $category_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $civilite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $autre_fonction;

    /**
     * @ORM\ManyToOne(targetEntity=Fonctions::class, inversedBy="membres")
     * @ORM\JoinColumn( name="fonction_id",nullable=true)
     */
    private $fonction_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siren_entreprise;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siret_entreprise;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $raison_social;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $effectifs_entreprise;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $chiffre_affaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $site_web;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nationalite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tel_principal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tel_secondaire;

    /**
     * @ORM\ManyToOne(targetEntity=Departements::class, inversedBy="membres")
     * @ORM\JoinColumn( name="departement_id",nullable=false)
     */
    private $departement_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $complement_adresse;

    /**
     * @ORM\ManyToOne(targetEntity=Villes::class, inversedBy="membres")
     * @ORM\JoinColumn( name="ville_id",nullable=false)
     */
    private $ville_id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $permis;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $code_postal;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $programme_ecole;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inscrit_nl;

    /**
     * @ORM\Column(type="date" , nullable=true)
     */
    private $date_add;

    /**
     * @ORM\OneToOne(targetEntity=Emailsubscription::class, mappedBy="id_membre", cascade={"persist", "remove"})
     */
    private $emailsubscription;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryId(): ?Categories
    {
        return $this->category_id;
    }

    public function setCategoryId(?Categories $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCivilite(): ?int
    {
        return $this->civilite;
    }

    public function setCivilite(int $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAutreFonction(): ?string
    {
        return $this->autre_fonction;
    }

    public function setAutreFonction(?string $autre_fonction): self
    {
        $this->autre_fonction = $autre_fonction;

        return $this;
    }

    public function getFonctionId(): ?Fonctions
    {
        return $this->fonction_id;
    }

    public function setFonctionId(?Fonctions $fonction_id): self
    {
        $this->fonction_id = $fonction_id;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

     /**
     * @see PasswordAuthenticatedUserInterface
     */

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSirenEntreprise(): ?string
    {
        return $this->siren_entreprise;
    }

    public function setSirenEntreprise(?string $siren_entreprise): self
    {
        $this->siren_entreprise = $siren_entreprise;

        return $this;
    }

    public function getSiretEntreprise(): ?string
    {
        return $this->siret_entreprise;
    }

    public function setSiretEntreprise(?string $siret_entreprise): self
    {
        $this->siret_entreprise = $siret_entreprise;

        return $this;
    }

    public function getRaisonSocial(): ?string
    {
        return $this->raison_social;
    }

    public function setRaisonSocial(?string $raison_social): self
    {
        $this->raison_social = $raison_social;

        return $this;
    }

    public function getEffectifsEntreprise(): ?int
    {
        return $this->effectifs_entreprise;
    }

    public function setEffectifsEntreprise(?int $effectifs_entreprise): self
    {
        $this->effectifs_entreprise = $effectifs_entreprise;

        return $this;
    }

    public function getChiffreAffaire(): ?float
    {
        return $this->chiffre_affaire;
    }

    public function setChiffreAffaire(?float $chiffre_affaire): self
    {
        $this->chiffre_affaire = $chiffre_affaire;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->site_web;
    }

    public function setSiteWeb(?string $site_web): self
    {
        $this->site_web = $site_web;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }


    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(?string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getTelPrincipal(): ?string
    {
        return $this->tel_principal;
    }

    public function setTelPrincipal(?string $tel_principal): self
    {
        $this->tel_principal = $tel_principal;

        return $this;
    }

    public function getTelSecondaire(): ?string
    {
        return $this->tel_secondaire;
    }

    public function setTelSecondaire(?string $tel_secondaire): self
    {
        $this->tel_secondaire = $tel_secondaire;

        return $this;
    }

    public function getDepartementId(): ?Departements
    {
        return $this->departement_id;
    }

    public function setDepartementId(?Departements $departement_id): self
    {
        $this->departement_id = $departement_id;

        return $this;
    }

    public function getComplementAdresse(): ?string
    {
        return $this->complement_adresse;
    }

    public function setComplementAdresse(?string $complement_adresse): self
    {
        $this->complement_adresse = $complement_adresse;

        return $this;
    }

    public function getVilleId(): ?Villes
    {
        return $this->ville_id;
    }

    public function setVilleId(?Villes $ville_id): self
    {
        $this->ville_id = $ville_id;

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

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(?string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getProgrammeEcole(): ?string
    {
        return $this->programme_ecole;
    }

    public function setProgrammeEcole(?string $programme_ecole): self
    {
        $this->programme_ecole = $programme_ecole;

        return $this;
    }

    public function getInscritNl(): ?bool
    {
        return $this->inscrit_nl;
    }

    public function setInscritNl(bool $inscrit_nl): self
    {
        $this->inscrit_nl = $inscrit_nl;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->date_add;
    }

    public function setDateAdd(\DateTimeInterface $date_add): self
    {
        $this->date_add = $date_add;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmailsubscription(): ?Emailsubscription
    {
        return $this->emailsubscription;
    }

    public function setEmailsubscription(?Emailsubscription $emailsubscription): self
    {
        // unset the owning side of the relation if necessary
        if ($emailsubscription === null && $this->emailsubscription !== null) {
            $this->emailsubscription->setIdMembre(null);
        }

        // set the owning side of the relation if necessary
        if ($emailsubscription !== null && $emailsubscription->getIdMembre() !== $this) {
            $emailsubscription->setIdMembre($this);
        }

        $this->emailsubscription = $emailsubscription;

        return $this;
    }

  

   
}
