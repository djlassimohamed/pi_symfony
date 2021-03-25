<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AbonnementRepository::class)
 */
class Abonnement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="abonnements")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today")
     */
    private $dateDebut;

    /**
     * @ORM\ManyToOne(targetEntity=Nutritionist::class, inversedBy="abonnements")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $nutritionist;

    /**
     * @ORM\OneToMany(targetEntity=InfoUserNutrition::class, mappedBy="abonnement")
     */
    private $infoUserNutritions;

    /**
     * @ORM\ManyToOne(targetEntity=Coach::class, inversedBy="abonnements")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $coach;

    public function __construct()
    {
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

    public function setUser(?Users $user): self
    {
        $this->user = $user;

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

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
            $infoUserNutrition->setAbonnement($this);
        }

        return $this;
    }

    public function removeInfoUserNutrition(InfoUserNutrition $infoUserNutrition): self
    {
        if ($this->infoUserNutritions->removeElement($infoUserNutrition)) {
            // set the owning side to null (unless already changed)
            if ($infoUserNutrition->getAbonnement() === $this) {
                $infoUserNutrition->setAbonnement(null);
            }
        }

        return $this;
    }

    public function getCoach(): ?Coach
    {
        return $this->coach;
    }

    public function setCoach(?Coach $coach): self
    {
        $this->coach = $coach;

        return $this;
    }
}
