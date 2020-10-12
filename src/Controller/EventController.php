<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/event", name="event_add")
     */
    public function add(EntityManagerInterface $em, Request $request)
    {
        //Création d'un nouvel objet $event
        $event = new Event();
        //On fixe les propriétés qui sont fixées par défaut
        $event->setCreationDate(new \DateTime('now'));
        //On appelle notre EventType
        $eventForm = $this->createForm(EventType::class, $event);

        $eventForm->handleRequest($request);
        if($eventForm->isSubmitted() && $eventForm->isValid()){
            $em->persist($event);
            $em->flush();

            $this->addFlash("success", "Your event has been saved !");
            return $this->redirectToRoute("event_details");
        }

        return $this->render('event/index.html.twig', [
            "eventForm" => $eventForm->createView()
        ]);
    }
}
