<?php

namespace App\Entity;

use App\Repository\EntrainementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EntrainementRepository::class)
 */
class Entrainement
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
     * @ORM\Column(name="titre", type="string", length=255)
     *
     * @Assert\Length(
     * min = 3,
     *max = 10,
     *minMessage = "le titre de l'entrainement doit comporter au moins 3 caractères",
     *maxMessage = "le titre de l'entrainement ne doit pas dépasser les {{limit}} 10 caractères"
     *
     * )
     *
     ** @Assert\NotNull(message="le titre de l'entrainement ne doit pas etre null ")
     *
     */
    private $titre;


    /**
     * @var string
     *
     * @ORM\Column(name="jour", type="string", length=255)
     *
     * @Assert\Length(
     * min = 3,
     *max = 10,
     *minMessage = "le jour de l'entrainement doit comporter au moins 3 caractères",
     *maxMessage = "le jour de l'entrainement ne doit pas dépasser les {{limit}} 10 caractères"
     *
     * )
     *
     ** @Assert\NotNull(message="le jour de l'entrainement ne doit pas etre null ")
     *
     */
    private $jour;

    /**
     * @ORM\Column(type="integer")
     */
    private $heure;



    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     *
     * @Assert\Length(
     * min = 3,
     *max = 10,
     *minMessage = "le type de l'entrainement doit comporter au moins 3 caractères",
     *maxMessage = "le type de l'entrainement ne doit pas dépasser les {{limit}} 10 caractères"
     *
     * )
     *
     ** @Assert\NotNull(message="le type de l'entrainement ne doit pas etre null ")
     *
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Coach::class, inversedBy="entrainements")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $coach;

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

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function getHeure(): ?int
    {
        return $this->heure;
    }

    public function setHeure(int $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
