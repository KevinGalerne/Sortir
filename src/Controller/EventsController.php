<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Event;
use App\Entity\Place;
use App\Form\EventType;
use App\Repository\CityRepository;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\DBAL\Types\StringType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_STUDENT")
 *
 */
class EventsController extends AbstractController
{

    /**
     * @Route("/create_event", name="create_event")
     */
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        // Creatin an instance of Event
        $event = new Event();

        // Creating the form
        $eventForm = $this->createForm(EventType::class, $event);
        $eventForm->handleRequest($request);

        //Hydratation des propriétés qui sont fixées automatiquement
        $event->setCreationDate(new \DateTime());

        // Setting the place parameters
        $event->setCity($request->get("event_city"));


        if (($eventForm->isSubmitted()) && $eventForm->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();
            return $this->redirectToRoute("welcome");

        }

        return $this->render('events/create_event.html.twig', [
            "eventForm" => $eventForm->createView()
        ]);
    }

    /**
     * @Route("/details_event", name="details_event")
     */
    public function details(EventRepository $eventRepository)
    {
        $eventToShow = $eventRepository->find(1);

        return $this->render('events/details_event.html.twig', [
            "eventToShow" => $eventToShow
        ]);
    }
}


























