<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    /**
     * @Route("/create_events", name="create_events")
     */
    public function create(EntityManager $entityManager, Request $request)
    {
        //Création d'un nouvel évènement
        $event = new Event();
        //Hydratation des propriétés qui sont fixées automatiquement
        $event->setCreationDate(new \DateTime());
        $event->setIsPublished("false");

        $eventForm = $this->createForm(EventType::class, $event);


        return $this->render('events/create_event.html.twig', [
            'controller_name' => 'EventsController',
        ]);
    }
}
