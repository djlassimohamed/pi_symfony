<?php

namespace App\Entity;

use App\Repository\NutritionistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=NutritionistRepository::class)
 */
class Nutritionist
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Users::class, inversedBy="nutritionist")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;


    /**
     * @var string
     *
     * @ORM\Column(name="diet", type="string", length=255)
     *
     * @Assert\Length(
     * min = 3,
     *max = 10,
     *minMessage = "diet de nutritionist doit comporter au moins 3 caractères",
     *maxMessage = "diet de nutritionist ne doit pas dépasser les {{limit}} 10 caractères"
     *
     * )
     *
     ** @Assert\NotNull(message="diet de nutritionist ne doit pas etre null ")
     *
     */
    private $diet;

    /**
     * @ORM\Column(type="float")
     */
    private $salary;

    /**
     * @ORM\OneToMany(targetEntity=Nutritionn::class, mappedBy="nutritionist")
     */
    private $nutritionns;

    /**
     * @ORM\OneToMany(targetEntity=Abonnement::class, mappedBy="nutritionist")
     */
    private $abonnements;

    /**
     * @ORM\OneToMany(targetEntity=Programmenutrition::class, mappedBy="nutritionist")
     */
    private $programmenutritions;

    /**
     * @ORM\OneToMany(targetEntity=InfoUserNutrition::class, mappedBy="nutritionist")
     */
    private $infoUserNutritions;

    public function __construct()
    {
        $this->nutritionns = new ArrayCollection();
        $this->abonnements = new ArrayCollection();
        $this->programmenutritions = new ArrayCollection();
        $this->infoUserNutritions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDiet(): ?string
    {
        return $this->diet;
    }

    public function setDiet(string $diet): self
    {
        $this->diet = $diet;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * @return Collection|Nutritionn[]
     */
    public function getNutritionns(): Collection
    {
        return $this->nutritionns;
    }

    public function addNutritionn(Nutritionn $nutritionn): self
    {
        if (!$this->nutritionns->contains($nutritionn)) {
            $this->nutritionns[] = $nutritionn;
            $nutritionn->setNutritionist($this);
        }

        return $this;
    }

    public function removeNutritionn(Nutritionn $nutritionn): self
    {
        if ($this->nutritionns->removeElement($nutritionn)) {
            // set the owning side to null (unless already changed)
            if ($nutritionn->getNutritionist() === $this) {
                $nutritionn->setNutritionist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Abonnement[]
     */
    public function getAbonnements(): Collection
    {
        return $this->abonnements;
    }

    public function addAbonnement(Abonnement $abonnement): self
    {
        if (!$this->abonnements->contains($abonnement)) {
            $this->abonnements[] = $abonnement;
            $abonnement->setNutritionist($this);
        }

        return $this;
    }

    public function removeAbonnement(Abonnement $abonnement): self
    {
        if ($this->abonnements->removeElement($abonnement)) {
            // set the owning side to null (unless already changed)
            if ($abonnement->getNutritionist() === $this) {
                $abonnement->setNutritionist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Programmenutrition[]
     */
    public function getProgrammenutritions(): Collection
    {
        return $this->programmenutritions;
    }

    public function addProgrammenutrition(Programmenutrition $programmenutrition): self
    {
        if (!$this->programmenutritions->contains($programmenutrition)) {
            $this->programmenutritions[] = $programmenutrition;
            $programmenutrition->setNutritionist($this);
        }

        return $this;
    }

    public function removeProgrammenutrition(Programmenutrition $programmenutrition): self
    {
        if ($this->programmenutritions->removeElement($programmenutrition)) {
            // set the owning side to null (unless already changed)
            if ($programmenutrition->getNutritionist() === $this) {
                $programmenutrition->setNutritionist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|InfoUserNutrition[]
     */
    public function getInfoUserNutritions(): Collection
    {
        return $this->infoUserNutritions;
    }

    public function addInfoUserNutrition(InfoUserNutrition $infoUserNutrition): self
    {
        if (!$this->infoUserNutritions->contains($infoUserNutrition)) {
            $this->infoUserNutritions[] = $infoUserNutrition;
            $infoUserNutrition->setNutritionist($this);
        }

        return $this;
    }

    public function removeInfoUserNutrition(InfoUserNutrition $infoUserNutrition): self
    {
        if ($this->infoUserNutritions->removeElement($infoUserNutrition)) {
            // set the owning side to null (unless already changed)
            if ($infoUserNutrition->getNutritionist() === $this) {
                $infoUserNutrition->setNutritionist(null);
            }
        }

        return $this;
    }
}
