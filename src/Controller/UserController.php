<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditAccountType;
use App\Form\EditPasswordType;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
            'controller_name' => 'UserController'
        ]);
    }


    /**
     * @Route("/account/{pseudo}", name="user_showProfil")
     */
    public function showProfil(UserRepository $userRepository, $pseudo,  EventRepository $eventRepository)
    {
        $profil = $userRepository->findOneBy(['pseudo' => $pseudo]);
        $userId = $profil->getId();
        $allEvents = $eventRepository->findBy(['Author' => $userId]);

        return $this->render('user/show_profil.html.twig', [
            'profilToShow' => $profil,'allEvents'=>$allEvents

        ]);
    }

    /**
     * Access to the author page
     * @Route("/show_author/{id}", name="show_author")
     * @param $id
     */
    public function showAuthor(UserRepository $userRepository, $id, EventRepository $eventRepository)
    {
        $allEvents = $eventRepository->findBy(['Author' => $id]);
        $profil = $userRepository->findOneBy(['id' => $id]);
        return $this->render('user/show_profil.html.twig', [
            'profilToShow' => $profil, 'allEvents'=>$allEvents
        ]);
    }

    /**
     * @Route("/account/edit", name="user_account_edit", priority="100")
     */
    public function editAccount(Request $request, EntityManagerInterface $objectManager)
    {
        $user = $this->getUser();

        $form = $this->createForm(EditAccountType::class, $user);
        $form->handleRequest($request);


        if ( $form->isSubmitted() && $form->isValid() ){

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['imageFile']->getData();

            if ($uploadedFile){
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads/profil_images';

                $newFilename = uniqid().'.'.$uploadedFile->guessExtension();

                $uploadedFile->move($destination, $newFilename);

                $user->setImageFilename($newFilename);
            }

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
