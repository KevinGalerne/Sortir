<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/add", name="profil_add")
     */
    public function add()
    {
        return $this->render('user/profil.html.twig', [


        ]);
    }
}
