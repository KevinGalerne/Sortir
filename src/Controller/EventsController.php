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
        $event->setIsPublished(false);
        $event->setAuthor($this->getUser());

        if (($eventForm->isSubmitted()) && $eventForm->isValid()) {

            // Setting the place parameters

            $event->setStreetNumber($request->get("event_street_number"));
            $event->setRoute($request->get("event_route"));
            $event->setPostalCode($request->get("event_postal_code"));
            $event->setLocality($request->get("event_locality"));
            $event->setCountry($request->get("event_country"));
            $event->setLatitude($request->get("latitude"));
            $event->setLongitude($request->get("longitude"));

            $entityManager->persist($event);
            $entityManager->flush();
            return $this->redirectToRoute("welcome");

        }

        return $this->render('events/create_event.html.twig', [
            "eventForm" => $eventForm->createView()
        ]);
    }

    /**
     * @Route("/details_event/{id}", name="details_event")
     */
    public function details($id, EventRepository $eventRepository)
    {
        $eventToShow = $eventRepository->find($id);

        return $this->render('events/details_event.html.twig', [
            "eventToShow" => $eventToShow
        ]);
    }

    /**
     * @Route("/list_events", name="liste_events")
     */
    public function list(EntityManagerInterface $em)
    {
        $eventRepository = $em->getRepository(Event::class);
        $allEvents = $eventRepository->findAll();


        return $this->render('events/list_events.html.twig', [
            "allEvents" => $allEvents
        ]);
    }
}


























