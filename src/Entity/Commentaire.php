<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today")
     */
    private $date;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=2000)
     *
     * @Assert\Length(
     * min = 3,
     *max = 2000,
     *minMessage = "la description du commentaire doit comporter au moins 3 caractères",
     *maxMessage = "la description du commentaire ne doit pas dépasser les {{limit}} 2000 caractères"
     *
     * )
     *
     ** @Assert\NotNull(message="la description du commentaire ne doit pas etre null ")
     *
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

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
