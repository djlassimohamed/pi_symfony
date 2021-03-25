<?php

namespace App\Entity;

use App\Repository\ProgrammenutritionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProgrammenutritionRepository::class)
 */
class Programmenutrition
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
    private $repas1;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $repas2;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $repas3;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $repas4;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $repas5;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jourrepot;

    /**
     * @ORM\OneToOne(targetEntity=InfoUserNutrition::class, inversedBy="programmenutrition", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $infoUserNutrition;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="programmenutritions")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Nutritionist::class, inversedBy="programmenutritions")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $nutritionist;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepas1(): ?string
    {
        return $this->repas1;
    }

    public function setRepas1(string $repas1): self
    {
        $this->repas1 = $repas1;

        return $this;
    }

    public function getRepas2(): ?string
    {
        return $this->repas2;
    }

    public function setRepas2(string $repas2): self
    {
        $this->repas2 = $repas2;

        return $this;
    }

    public function getRepas3(): ?string
    {
        return $this->repas3;
    }

    public function setRepas3(string $repas3): self
    {
        $this->repas3 = $repas3;

        return $this;
    }

    public function getRepas4(): ?string
    {
        return $this->repas4;
    }

    public function setRepas4(string $repas4): self
    {
        $this->repas4 = $repas4;

        return $this;
    }

    public function getRepas5(): ?string
    {
        return $this->repas5;
    }

    public function setRepas5(string $repas5): self
    {
        $this->repas5 = $repas5;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getJourrepot(): ?string
    {
        return $this->jourrepot;
    }

    public function setJourrepot(string $jourrepot): self
    {
        $this->jourrepot = $jourrepot;

        return $this;
    }

    public function getInfoUserNutrition(): ?InfoUserNutrition
    {
        return $this->infoUserNutrition;
    }

    public function setInfoUserNutrition(InfoUserNutrition $infoUserNutrition): self
    {
        $this->infoUserNutrition = $infoUserNutrition;

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
