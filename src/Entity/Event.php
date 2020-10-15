<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    // PROPRIETES ---------------------------------------------------------------------------------------------------
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

    //RELATIONS -----------------------------------------------------------------------------------------------------
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Author;

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

    public function getStreetNumber(): ?int
    {
        return $this->street_number;
    }

    public function setStreetNumber(?int $street_number): self
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

    public function setPostalCode(int $postal_code): self
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
}
