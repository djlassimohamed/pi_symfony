<?php

namespace App\Entity;

use App\Repository\NutritionnRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=NutritionnRepository::class)
 */
class Nutritionn
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     *
     * @Assert\Length(
     * min = 3,
     *max = 10,
     *minMessage = "La description de nutrition doit comporter au moins 3 caractères",
     *maxMessage = "La description de nutrition ne doit pas dépasser les {{limit}} 10 caractères"
     *
     * )
     *
     ** @Assert\NotNull(message="La description de nutrition ne doit pas etre null ")
     *
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $kcal;

    /**
     * @ORM\Column(type="integer")
     */
    private $fats;

    /**
     * @ORM\Column(type="integer")
     */
    private $salt;

    /**
     * @ORM\Column(type="integer")
     */
    private $proteins;

    /**
     * @ORM\Column(type="integer")
     */
    private $carbs;

    /**
     * @ORM\Column(type="integer")
     */
    private $sugars;

    /**
     * @ORM\ManyToOne(targetEntity=Nutritionist::class, inversedBy="nutritionns")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $nutritionist;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getKcal(): ?int
    {
        return $this->kcal;
    }

    public function setKcal(int $kcal): self
    {
        $this->kcal = $kcal;

        return $this;
    }

    public function getFats(): ?int
    {
        return $this->fats;
    }

    public function setFats(int $fats): self
    {
        $this->fats = $fats;

        return $this;
    }

    public function getSalt(): ?int
    {
        return $this->salt;
    }

    public function setSalt(int $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    public function getProteins(): ?int
    {
        return $this->proteins;
    }

    public function setProteins(int $proteins): self
    {
        $this->proteins = $proteins;

        return $this;
    }

    public function getCarbs(): ?int
    {
        return $this->carbs;
    }

    public function setCarbs(int $carbs): self
    {
        $this->carbs = $carbs;

        return $this;
    }

    public function getSugars(): ?int
    {
        return $this->sugars;
    }

    public function setSugars(int $sugars): self
    {
        $this->sugars = $sugars;

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
