<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Users implements UserInterface
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
     * @ORM\Column(name="email", type="string", length=255)
     *
     * @Assert\Length(
     * min = 3,
     *max = 50,
     *minMessage = "l'email de l'utilisateur doit comporter au moins 3 caractères",
     *maxMessage = "l'email de l'utilisateur ne doit pas dépasser les {{limit}} 50 caractères"
     *
     * )
     *
     ** @Assert\NotNull(message="l'email de l'utilisateur ne doit pas etre null ")
     *
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToOne(targetEntity=Coach::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $coach;

    /**
     * @ORM\OneToOne(targetEntity=Nutritionist::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $nutritionist;

    /**
     * @ORM\OneToMany(targetEntity=Abonnement::class, mappedBy="user")
     */
    private $abonnements;

    /**
     * @ORM\OneToMany(targetEntity=Reclamation::class, mappedBy="user")
     */
    private $reclamations;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="user")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="user")
     */
    private $commentaires;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activation_token;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datenaissance;

    /**
     * @ORM\OneToMany(targetEntity=InfoUserNutrition::class, mappedBy="user")
     */
    private $infoNutritions;

    /**
     * @ORM\OneToMany(targetEntity=Programmenutrition::class, mappedBy="user")
     */
    private $programmenutritions;

    /**
     * @ORM\OneToMany(targetEntity=PanierProduit::class, mappedBy="user")
     */
    private $panierProduits;

    /**
     * @ORM\ManyToMany(targetEntity=Post::class, mappedBy="likes")
     * @ORM\JoinTable(name="likes")}
     */
    private $postlikes;

    /**
     * @ORM\ManyToMany(targetEntity=Post::class, mappedBy="dislikes")
     * @ORM\JoinTable(name="dislikes")}
     */
    private $postdislikes;

    public function __construct()
    {
        $this->abonnements = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->infoNutritions = new ArrayCollection();
        $this->programmenutritions = new ArrayCollection();
        $this->paniers = new ArrayCollection();
        $this->panierProduits = new ArrayCollection();
        $this->postlikes = new ArrayCollection();
        $this->postdislikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getCoach(): ?Coach
    {
        return $this->coach;
    }

    public function setCoach(Coach $coach): self
    {
        // set the owning side of the relation if necessary
        if ($coach->getUser() !== $this) {
            $coach->setUser($this);
        }

        $this->coach = $coach;

        return $this;
    }

    public function getNutritionist(): ?Nutritionist
    {
        return $this->nutritionist;
    }

    public function setNutritionist(Nutritionist $nutritionist): self
    {
        // set the owning side of the relation if necessary
        if ($nutritionist->getUser() !== $this) {
            $nutritionist->setUser($this);
        }

        $this->nutritionist = $nutritionist;

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
            $abonnement->setUser($this);
        }

        return $this;
    }

    public function removeAbonnement(Abonnement $abonnement): self
    {
        if ($this->abonnements->removeElement($abonnement)) {
            // set the owning side to null (unless already changed)
            if ($abonnement->getUser() === $this) {
                $abonnement->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reclamation[]
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations[] = $reclamation;
            $reclamation->setUser($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getUser() === $this) {
                $reclamation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
            }
        }

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(?string $activation_token): self
    {
        $this->activation_token = $activation_token;

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

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getDatenaissance(): ?\DateTimeInterface
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(\DateTimeInterface $datenaissance): self
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    /**
     * @return Collection|InfoUserNutrition[]
     */
    public function getInfoNutritions(): Collection
    {
        return $this->infoNutritions;
    }

    public function addInfoNutrition(InfoUserNutrition $infoNutrition): self
    {
        if (!$this->infoNutritions->contains($infoNutrition)) {
            $this->infoNutritions[] = $infoNutrition;
            $infoNutrition->setUser($this);
        }

        return $this;
    }

    public function removeInfoNutrition(InfoUserNutrition $infoNutrition): self
    {
        if ($this->infoNutritions->removeElement($infoNutrition)) {
            // set the owning side to null (unless already changed)
            if ($infoNutrition->getUser() === $this) {
                $infoNutrition->setUser(null);
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
            $programmenutrition->setUser($this);
        }

        return $this;
    }

    public function removeProgrammenutrition(Programmenutrition $programmenutrition): self
    {
        if ($this->programmenutritions->removeElement($programmenutrition)) {
            // set the owning side to null (unless already changed)
            if ($programmenutrition->getUser() === $this) {
                $programmenutrition->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PanierProduit[]
     */
    public function getPanierProduits(): Collection
    {
        return $this->panierProduits;
    }

    public function addPanierProduit(PanierProduit $panierProduit): self
    {
        if (!$this->panierProduits->contains($panierProduit)) {
            $this->panierProduits[] = $panierProduit;
            $panierProduit->setUser($this);
        }

        return $this;
    }

    public function removePanierProduit(PanierProduit $panierProduit): self
    {
        if ($this->panierProduits->removeElement($panierProduit)) {
            // set the owning side to null (unless already changed)
            if ($panierProduit->getUser() === $this) {
                $panierProduit->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPostlikes(): Collection
    {
        return $this->postlikes;
    }

    public function addPostlike(Post $postlike): self
    {
        if (!$this->postlikes->contains($postlike)) {
            $this->postlikes[] = $postlike;
            $postlike->addLike($this);
        }

        return $this;
    }

    public function removePostlike(Post $postlike): self
    {
        if ($this->postlikes->removeElement($postlike)) {
            $postlike->removeLike($this);
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPostdislikes(): Collection
    {
        return $this->postdislikes;
    }

    public function addPostdislike(Post $postdislike): self
    {
        if (!$this->postdislikes->contains($postdislike)) {
            $this->postdislikes[] = $postdislike;
            $postdislike->addDislike($this);
        }

        return $this;
    }

    public function removePostdislike(Post $postdislike): self
    {
        if ($this->postdislikes->removeElement($postdislike)) {
            $postdislike->removeDislike($this);
        }

        return $this;
    }

}
