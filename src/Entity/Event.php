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
     * @ORM\Column (type="dateinterval")
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

    //RELATIONS -----------------------------------------------------------------------------------------------------
    /**
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="event")
     * @ORM\JoinColumn(nullable=false)
     */
    private $place;

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

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
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



}
