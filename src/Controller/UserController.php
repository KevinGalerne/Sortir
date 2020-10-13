<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/add", name="profil_add")
     */
    public function add(EntityManagerInterface $entityManager)
    {
        $User = new User();

        $userForm = $this->createForm(UserType::class, $User);

       

        return $this->render('user/profil.html.twig', [
            "userForm"=> $userForm->createView()


        ]);
    }
}
