<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Event;
use App\Entity\Place;
use App\Entity\User;
use App\Form\EventType;
use App\Repository\CampusRepository;
use App\Repository\CityRepository;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\DBAL\Types\StringType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use phpDocumentor\Reflection\Types\This;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\WorkflowInterface;


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
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        CampusRepository $campusRepository,
        WorkflowInterface $eventPublishingStateMachine)
    {

        // Get all the campus in the database and return it to the twig templates
        $allCampus = $campusRepository->findAll();


        // Creatin an instance of Event
        $event = new Event();


        // Getting the user campus, $user is initially typed UserInterface, we retype it to User
        /** @var User $user */
        $user = $this->getUser();


        /** @var Campus $campus */
        $campus = $user->getCampus();

        // Creating the form
        $eventForm = $this->createForm(EventType::class, $event);
        $eventForm->handleRequest($request);

        //Hydratation des propriétés qui sont fixées automatiquement
        $event->setCreationDate(new \DateTime());
        $event->setIsPublished(false);
        $event->setCampus($campus);
        $event->setAuthor($user);

        // Getting the workflow (statemachine because only one value possible), and setting the initial value
        // getMarking(parameter) is used to set the instance to the initial value /**/
        $eventPublishingStateMachine->getMarking($event);



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
            "eventForm" => $eventForm->createView(), 'allCampus' => $allCampus
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
    public function list(EntityManagerInterface $em, CampusRepository $campusRepository)
    {
        // Get all the campus in the database and return it to the twig templates
        $allCampus = $campusRepository->findAll();

        $eventRepository = $em->getRepository(Event::class);
        $allEvents = $eventRepository->findAll();


        return $this->render('events/list_events.html.twig', [
            "allEvents" => $allEvents, 'allCampus' => $allCampus
        ]);
    }


    /**
     * This function return a list of events based on a date choice
     * @param EventRepository $eventRepository
     * @param Request $request
     * @param : String
     * @return \Symfony\Component\HttpFoundation\Response : [events]
     * @Route ("/get_event", name="get_event")
     */
    public function getEvent(EventRepository $eventRepository, Request $request, CampusRepository $campusRepository)
    {

        // Getting the connected user
        $user = $this->getUser();


        // Get all the campus in the database and return it to the twig templates
        $allCampus = $campusRepository->findAll();

        // Get the parameter sent by the user and convert it into DateTime object (database used DateTime)
        $startDate = empty($request->get('startdate')) ? null : date_create($request->get('startdate'));
        $endDate = empty($request->get('enddate')) ? null : date_create($request->get('enddate'));


        // Get the checkbox parameters
        $userCheckBox = $request->get('usercheckbox');
        $registeredEvent = $request->get('registeredevent');
        $nonRegisteredEvent =$request->get('nonregisteredevent');
        $passedEvent = $request->get('passed');
        $participant = null;
        $nonRegistered=null;
        $now = null;
        $userId = null;

        if ($userCheckBox) {
            /** @var User $user */

            $userId = $user->getId();
        } else {
            $userId = 0;
        }
        if ($registeredEvent) {
            $participant = $this->getUser();;
        }
        if ($passedEvent) {
            $now = date_create(date('m/d/Y h:i:s a', time()));
        }
        if ($nonRegisteredEvent) {
            $nonRegistered = $user;
        }


        $campus = $request->get('campus');
        $keyword = $request->get('keyword');

        // Calling the function in the repository and passing the parameters

        $allEvents = $eventRepository->findByCriteria($startDate, $endDate, $keyword, $userId, $campus, $participant, $now, $nonRegistered);

        return $this->render('events/list_events.html.twig', ["allEvents" => $allEvents, "allCampus" => $allCampus]);
    }


    /**
     * @Route ("/participate/{id}", name="participate_event")
     * @param EventRepository $eventRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function participate(EventRepository $eventRepository, Request $request, $id, EntityManagerInterface $em)
    {
        /** @var User $user */
        $user = $this->getUser();

        $eventToShow = $eventRepository->find($id);

        if ($eventToShow->getRegisteredParticipants()->count() < $eventToShow->getMaxParticipants()) {
            $eventToShow->addRegisteredParticipant($user);
            $em->persist($eventToShow);
            $em->flush();
        }

        return $this->redirectToRoute('details_event', [
            'id' => $eventToShow->getId()
        ]);
    }

    /**
     * This function allows the user to cancel an event he created
     * @Route ("/cancel/{id}", name="cancel_event")
     * @param EventRepository $eventRepository
     * @param $id
     */
    public function cancel(EventRepository $eventRepository, $id)
    {
        /** @var User $user */
        $user = $this->getUser();
        $eventToCancel = $eventRepository->find($id);

        if ($eventToCancel->getAuthor()->getId() == $user->getId())
        {
            $eventRepository->cancelEvent($id);
        }

        return $this->redirectToRoute('list_events');
    }

    /**
     * This function allows the user to open an event he created
     * @Route ("/open/{id}", name="open_event")
     * @param EventRepository $eventRepository
     * @param $id
     */
    public function open(EventRepository $eventRepository, $id, WorkflowInterface $eventPublishingStateMachine){

        // Getting the user
        /** @var User $user */
        $user = new User();

        $user = $this->getUser();

        // Getting the event
        $eventToPublish = $eventRepository->findOneBy($id);

        //
        $eventPublishingStateMachine->apply($eventToPublish, EVENT::IC_TO_OPENED);





    }

}


























