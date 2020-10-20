<?php

namespace App\Controller;

use App\Form\EditAccountType;
use App\Form\EditPasswordType;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @IsGranted ("ROLE_STUDENT")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/account/show", name="user_account_show")
     */
    public function showAccount()
    {
        return $this->render('user/account_show.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


    /**
     * @Route("/account/{pseudo}", name="user_showProfil")
     */
    public function showProfil(UserRepository $userRepository, $pseudo, EventRepository $eventRepository)
    {
        $profil = $userRepository->findOneBy(['pseudo' => $pseudo]);

        return $this->render('user/show_profil.html.twig', [
            'profilToShow' => $profil,
        ]);
    }

    /**
     * @Route("/account/edit", name="user_account_edit")
     */
    public function editAccount(Request $request, EntityManagerInterface $objectManager)
    {
        $user = $this->getUser();

        $form = $this->createForm(EditAccountType::class, $user);
        $form->handleRequest($request);


        if ( $form->isSubmitted() && $form->isValid() ){

            $objectManager->persist($user);
            $objectManager->flush();

            $this->addFlash(
                'success',
                'Vos informations ont bien été modifiés ! '
            );
            return $this->redirectToRoute("user_account_show");
        }


        return $this->render('user/account_edit.html.twig', [
            'editForm'=> $form->createView(),
                    ]);
    }


    /**
     * @Route("/account/edit/new_password", name="user_password_edit")
     */
    public function editPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em)
    {

        {
            $user = $this->getUser();
            $form = $this->createForm(EditPasswordType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {


                $oldPassword = $form->get('oldPassword')->getData();


                // Si l'ancien mot de passe est bon
                if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                    $newEncodedPassword = $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData());
                    $user->setPassword($newEncodedPassword);

                    $em->persist($user);
                    $em->flush();

                    $this->addFlash('success', 'Votre mot de passe à bien été changé !');

                    return $this->render('user/account_show.html.twig');
                } else {
                    $form->get('oldPassword')->addError(new FormError('Ancien mot de passe incorrect'));
                }
            }

            return $this->render('user/edit_password.html.twig', [
                'editPasswordForm'=> $form->createView(),
            ]);
        }
    }
}
