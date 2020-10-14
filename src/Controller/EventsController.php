<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Event;
use App\Entity\Place;
use App\Form\EventType;
use App\Repository\CityRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
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
     * @Route("/create_events", name="create_events")
     */
    public function create(Request $request)
    {
        //Création d'un nouvel évènement
        $event = new Event();
        //Hydratation des propriétés qui sont fixées automatiquement
        $event->setCreationDate(new \DateTime());
        $event->setIsPublished("false");

        $eventForm = $this->createForm(EventType::class, $event);

        return $this->render('events/create_event.html.twig', [
            "eventForm" => $eventForm->createView()
        ]);
    }
}
