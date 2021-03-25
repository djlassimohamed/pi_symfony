<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReclamationRepository::class)
 */
class Reclamation
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
     * @ORM\Column(name="type", type="string", length=255)
     *
     * @Assert\Length(
     * min = 3,
     *max = 50,
     *minMessage = "Le type de la reclamation doit comporter au moins 3 caractères",
     *maxMessage = "Le type de la reclamation ne doit pas dépasser les {{limit}} 50 caractères"
     *
     * )
     *
     ** @Assert\NotNull(message="Le type de la reclamation ne doit pas etre null ")
     *
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     * min = 0,
     *max = 50,
     *minMessage = "Le status de la reclamation doit comporter au moins 0 caractères",
     *maxMessage = "Le status de la reclamation ne doit pas dépasser les {{limit}} 10 caractères"
     *
     * )
     *
     ** @Assert\NotNull(message="Le status de la reclamation ne doit pas etre null ")
     *
     */
    private $status;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000)
     *
     * @Assert\Length(
     * min = 3,
     *max = 1000,
     *minMessage = "La description de la reclamation doit comporter au moins 3 caractères",
     *maxMessage = "La description de la reclamation ne doit pas dépasser les {{limit}} 1000 caractères"
     *
     * )
     *
     ** @Assert\NotNull(message="La description de la reclamation ne doit pas etre null ")
     *
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="reclamations")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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
}
