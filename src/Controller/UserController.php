<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/add", name="profil_add")
     */
    public function add()
    {
        $userForm = $this->createForm(UserType::class);

        return $this->render('user/profil.html.twig', [
            "userForm"=> $userForm->createView()


        ]);
    }
}
