<?php

namespace App\Entity;

use App\Repository\InfoUserNutritionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InfoUserNutritionRepository::class)
 */
class InfoUserNutrition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $ojectif;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $blessure;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $mangezpas;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $supplementali;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $probleme;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="integer")
     */
    private $taille;

    /**
     * @ORM\Column(type="float")
     */
    private $poids;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sexe;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="infoNutritions")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Programmenutrition::class, mappedBy="infoUserNutrition", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $programmenutrition;

    /**
     * @ORM\ManyToOne(targetEntity=Abonnement::class, inversedBy="infoUserNutritions")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $abonnement;

    /**
     * @ORM\ManyToOne(targetEntity=Nutritionist::class, inversedBy="infoUserNutritions")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $nutritionist;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOjectif(): ?string
    {
        return $this->ojectif;
    }

    public function setOjectif(string $ojectif): self
    {
        $this->ojectif = $ojectif;

        return $this;
    }

    public function getBlessure(): ?string
    {
        return $this->blessure;
    }

    public function setBlessure(string $blessure): self
    {
        $this->blessure = $blessure;

        return $this;
    }

    public function getMangezpas(): ?string
    {
        return $this->mangezpas;
    }

    public function setMangezpas(string $mangezpas): self
    {
        $this->mangezpas = $mangezpas;

        return $this;
    }

    public function getSupplementali(): ?string
    {
        return $this->supplementali;
    }

    public function setSupplementali(string $supplementali): self
    {
        $this->supplementali = $supplementali;

        return $this;
    }

    public function getProbleme(): ?string
    {
        return $this->probleme;
    }

    public function setProbleme(string $probleme): self
    {
        $this->probleme = $probleme;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(float $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProgrammenutrition(): ?Programmenutrition
    {
        return $this->programmenutrition;
    }

    public function setProgrammenutrition(Programmenutrition $programmenutrition): self
    {
        // set the owning side of the relation if necessary
        if ($programmenutrition->getInfoUserNutrition() !== $this) {
            $programmenutrition->setInfoUserNutrition($this);
        }

        $this->programmenutrition = $programmenutrition;

        return $this;
    }

    public function getAbonnement(): ?Abonnement
    {
        return $this->abonnement;
    }

    public function setAbonnement(?Abonnement $abonnement): self
    {
        $this->abonnement = $abonnement;

        return $this;
    }

    public function getNutritionist(): ?Nutritionist
    {
        return $this->nutritionist;
    }

    public function setNutritionist(?Nutritionist $nutritionist): self
    {
        $this->nutritionist = $nutritionist;

        return $this;
    }
}
