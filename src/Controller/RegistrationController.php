<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 *
 */
class RegistrationController extends AbstractController
{
    /**
     * @IsGranted ("ROLE_ADMIN")
     * Register a new user
     * @Route("/register", name="app_register")
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder,
                             GuardAuthenticatorHandler $guardHandler,
                             LoginFormAuthenticator $authenticator,
                             ValidatorInterface $validator): Response
    {


        // Creating an instance of user, empty for the moment
        $user = new User();

        // Creating the form
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        // If form is submitted, and valid, then continue
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['imageFile']->getData();

            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/profil_images';

                $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();

                $uploadedFile->move($destination, $newFilename);

                $user->setImageFilename($newFilename);
            }

            // We hash the password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            //We save the data inside the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


              }


        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);


    }
}

