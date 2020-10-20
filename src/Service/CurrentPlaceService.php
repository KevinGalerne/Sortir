<?php

namespace App\Service;
use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class CurrentPlaceService
{
    private $eventPublishingStateMachine;
    private $entityManager;
    private $eventRepository;

    public function __construct(WorkflowInterface $eventPublishingStateMachine, EntityManagerInterface $entityManager, EventRepository $eventRepository)
    {

        $this->eventPublishingStateMachine = $eventPublishingStateMachine;
        $this->entityManager = $entityManager;
        $this->eventRepository = $eventRepository;
    }


    public function open($id)
    {
        $eventToPublish = $this->eventRepository->find($id);

        //Apply the "opened" state to the event
        $this->eventPublishingStateMachine->apply($eventToPublish, EVENT::IC_TO_OPENED);

        //Updating in database
        $this->entityManager->persist($eventToPublish);
        $this->entityManager->flush();
    }


    public function past($id)
    {
        $eventToPast = $this->eventRepository->find($id);

        $this->eventPublishingStateMachine->apply($eventToPast, EVENT::OPENED_TO_PAST);
        //Updating in database
        $this->entityManager->persist($eventToPast);
        $this->entityManager->flush();


    }

}