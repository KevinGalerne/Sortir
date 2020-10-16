<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Event;
use App\Entity\Place;
use App\Entity\User;
use App\Form\EventType;
use App\Repository\CampusRepository;
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
     * Create a new event
     *
     * @Route("/create_event", name="create_event")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, EntityManagerInterface $entityManager, CampusRepository $campus)
    {
        // Creatin an instance of Event
        $event = new Event();
        $campus = new Campus();

        /** @var User $user */
        $user = $this->getUser();
        $campus = $user->getCampus();


        // Creating the form
        $eventForm = $this->createForm(EventType::class, $event);
        $eventForm->handleRequest($request);
        $event->setCampus($campus);

        //Hydratation des propriétés qui sont fixées automatiquement
        $event->setCreationDate(new \DateTime());
        $event->setIsPublished(false);





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

            $id = $event->getId();
            return $this->redirectToRoute("details_event", ['id' => $id]);

        }

        return $this->render('events/create_event.html.twig', [
            "eventForm" => $eventForm->createView()
        ]);
    }

    /**
     * Access to the event details
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
     * Access to the event list
     * @Route("/list_events", name="list_events")
     */
    public function list(EntityManagerInterface $em)
    {
        $eventRepository = $em->getRepository(Event::class);
        $allEvents = $eventRepository->findAll();


        return $this->render('events/list_events.html.twig', [
            "allEvents" => $allEvents
        ]);
    }


    /**
     * This function return a list of events based on a criteria
     * @param EventRepository $eventRepository
     * @param Request $request
     * @param : String
     * @return \Symfony\Component\HttpFoundation\Response : [events]
     * @Route ("/get_event", name="get_event")
     */
    public function getEventBy(EventRepository $eventRepository, Request $request, CampusRepository $campusRepository)
    {

        $param = $request->get('param');
        $campus = $campusRepository->findOneBy(['name' => $param]);


        $allEvents = $eventRepository->findBy(['Author' => $campus]);


        return $this->render('events/list_events', ["allEvents" => $allEvents]);
    }


}


























