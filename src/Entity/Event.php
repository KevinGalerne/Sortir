<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    // PROPRIETES ---------------------------------------------------------------------------------------------------
    /**
     * @var
     */
    private $currentPlace;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(max="100", maxMessage="The name should be 100 characters max !")
     * @ORM\Column (type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column (type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\Column (type="datetime")
     */
    private $eventDate;

    /**
     * @ORM\Column (type="time", nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column (type="datetime")
     */
    private $subscriptionLimitDate;

    /**
     * @ORM\Column (type="integer")
     */
    private $maxParticipants;

    /**
     * @ORM\Column (type="text")
     */
    private $description;

    /**
     * @ORM\Column (type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $place_name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $street_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $route;

    /**
     * @ORM\Column(type="string")
     */
    private $postal_code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $locality;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     */
    private $longitude;

    //RELATIONS -----------------------------------------------------------------------------------------------------
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Author;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="eventsRegisteredTo")
     */
    private $registeredParticipants;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campus;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;


    public function __construct()
    {
        $this->registeredParticipants = new ArrayCollection();
    }



    //GETTERS & SETTERS ---------------------------------------------------------------------------------------------
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate($creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * @param mixed $eventDate
     */
    public function setEventDate($eventDate): void
    {
        $this->eventDate = $eventDate;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionLimitDate()
    {
        return $this->subscriptionLimitDate;
    }

    /**
     * @param mixed $subscriptionLimitDate
     */
    public function setSubscriptionLimitDate($subscriptionLimitDate): void
    {
        $this->subscriptionLimitDate = $subscriptionLimitDate;
    }

    /**
     * @return mixed
     */
    public function getMaxParticipants()
    {
        return $this->maxParticipants;
    }

    /**
     * @param mixed $maxParticipants
     */
    public function setMaxParticipants($maxParticipants): void
    {
        $this->maxParticipants = $maxParticipants;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * @param mixed $isPublished
     */
    public function setIsPublished($isPublished): void
    {
        $this->isPublished = $isPublished;
    }

    public function getAuthor(): ?User
    {
        return $this->Author;
    }

    public function setAuthor(?User $Author): self
    {
        $this->Author = $Author;

        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->street_number;
    }

    public function setStreetNumber(string $street_number): self
    {
        $this->street_number = $street_number;

        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getLocality(): ?string
    {
        return $this->locality;
    }

    public function setLocality(string $locality): self
    {
        $this->locality = $locality;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPlaceName(): ?string
    {
        return $this->place_name;
    }

    public function setPlaceName(?string $place_name): self
    {
        $this->place_name = $place_name;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getRegisteredParticipants(): Collection
    {
        return $this->registeredParticipants;
    }

    public function addRegisteredParticipant(User $registeredParticipant): self
    {
        if (!$this->registeredParticipants->contains($registeredParticipant)) {
            $this->registeredParticipants[] = $registeredParticipant;
        }

        return $this;
    }

    public function removeRegisteredParticipant(User $registeredParticipant): self
    {
        if ($this->registeredParticipants->contains($registeredParticipant)) {
            $this->registeredParticipants->removeElement($registeredParticipant);
        }

        return $this;
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
    public function setCampusName(?Campus $campus): self
    {
        $this->campus = $campus->getName();

        return $this;
    }
    public function setCampusId(?Campus $campus): self
    {
        $this->campusid = $campus->getId();

        return $this;
    }

    public function isOpen()
    {
        return /*$this->getSubscriptionLimitDate() > new \DateTime() &&*/
            $this->getMaxParticipants() <= $this->getRegisteredParticipants()->count();
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrentPlace()
    {
        return $this->currentPlace;
    }

    /**
     * @param mixed $currentPlace
     */
    public function setCurrentPlace($currentPlace): void
    {
        $this->currentPlace = $currentPlace;
    }

}
