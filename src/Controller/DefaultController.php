<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * This is the main route for the website URL
     * @Route("/", name="welcome")
     * @author Laetitia, Samy-Lee, Raphael, Kevin
     */
    public function welcome()
    {
        return $this->render('default/welcome.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}