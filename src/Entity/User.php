<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(message="Veuillez s'il vous plaît entrer un email valide.")
     * @Assert\NotBlank (message="Nous avons besoin de votre mail voyons")
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
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\NotBlank(message="Le pseudo est obligatoire")
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=50)
     *  @Assert\NotBlank(message="Le nom de famille est obligatoire")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=50)
     *  @Assert\NotBlank(message="Le prénom est obligatoire")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\Length(
     *     max="10",
     *     min="10",
     *     exactMessage="Le numéro de téléphone doit être composé de 10 chiffres.",
     * )
     * @Assert\NotBlank(message="Le numéro de téléphone est obligatoire")
     */
    private $phoneNumber;

    // RELATIONS ---------------------------------------------------------------------------------------------------
    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campus;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="Author")
     */
    private $events;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="registeredParticipants")
     */
    private $eventsRegisteredTo;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->eventsRegisteredTo = new ArrayCollection();
    }


    //--------------------------------------GETTERS & SETTERS --------------------------------------------------------

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
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo): void
    {
        $this->pseudo = $pseudo;
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
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setAuthor($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getAuthor() === $this) {
                $event->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEventsRegisteredTo(): Collection
    {
        return $this->eventsRegisteredTo;
    }

    public function addEventsRegisteredTo(Event $eventsRegisteredTo): self
    {
        if (!$this->eventsRegisteredTo->contains($eventsRegisteredTo)) {
            $this->eventsRegisteredTo[] = $eventsRegisteredTo;
            $eventsRegisteredTo->addRegisteredParticipant($this);
        }

        return $this;
    }

    public function removeEventsRegisteredTo(Event $eventsRegisteredTo): self
    {
        if ($this->eventsRegisteredTo->contains($eventsRegisteredTo)) {
            $this->eventsRegisteredTo->removeElement($eventsRegisteredTo);
            $eventsRegisteredTo->removeRegisteredParticipant($this);
        }

        return $this;
    }
}
