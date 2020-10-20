<?php

namespace AppBundle\Service;

use App\Entity\Event;
use App\Entity\User;
use App\Repository\CampusRepository;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\WorkflowInterface;

class CurrentPlaceService
{
    private $eventPublishingStateMachine;
    private $entityManager;
    private $eventRepository;

    public function __construct(WorkflowInterface $eventPublishingStateMachine, EntityManagerInterface $entityManager, EventRepository $eventRepository) {

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
        $entityManager->persist($eventToPublish);
        $entityManager->flush();
    }

    public function past(Array)
    {
        $now = new \DateTime();

        foreach ($allEvents as $event)
        {
            if ($event)
        }
    }

    /**
     * @Route ("/past_activity", name="past_activity")
     * This function set all the activities where the date is before now to "past_activity" state
     * @param EventRepository $eventRepository
     */
    public function past_activity(EntityManagerInterface $entityManager,
                                  EventRepository $eventRepository,
                                  $id,
                                  WorkflowInterface $eventPublishingStateMachine,
                                  CampusRepository $campusRepository)
    {
        // Get all the campus in the database and return it to the twig templates
        $allCampus = $campusRepository->findAll();
        $allEvents = $eventRepository->findAll();

        // Getting the datetime of now
        $now = new \DateTime();


        foreach ($allEvents as $event) {
            if ($event->getEventDate() < $now) {
                //a remplacer après ajout de la fonction opened to current
                $eventPublishingStateMachine->apply($event, EVENT::OPENED_TO_PAST);
            }

            // Updating the database
            $entityManager->flush();




    }


}


}