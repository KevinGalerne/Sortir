<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/add", name="profil_add")
     */

    //création de la requete
    public function add(Request $request, EntityManagerInterface $entityManager )
    {
        //creation d'un nouvel user
        $user = new User();

        //création du formulaire
        //récupération des données
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);


        //si le formulaire est soumis et que les données sont valides
        if($userForm->isSubmitted() && $userForm->isValid()) {

            //garde en mémoire puis enregistre
            $entityManager->persist($user);
            $entityManager->flush();

        }


        return $this->render('user/profil.html.twig', [
            "userForm"=> $userForm->createView()

        ]);
    }
}
