<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/add", name="profil_add")
     */

    //create new request
    public function add(Request $request, EntityManagerInterface $entityManager,UserPasswordEncoderInterface $passwordEncoder)
    {
        //create new user
        $user = new User();


        //create form and get data
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);


        //if form is submit and if data are validate
        if($userForm->isSubmitted() && $userForm->isValid()) {

            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $userForm->get('password')->getData()
                )
            );


            //save data
            $entityManager->persist($user);
            $entityManager->flush();

        }


        return $this->render('user/profil.html.twig', [
            "userForm"=> $userForm->createView()

        ]);
    }
}
