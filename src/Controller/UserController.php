<?php

namespace App\Controller;

use App\Form\EditAccountType;
use App\Form\EditPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    public function editPassword(Request $request)
    {

        $user = $this->getUser();

        $form = $this->createForm(EditPasswordType::class, $user);
        $form->handleRequest($request);


        return $this->render('user/edit_password', [
            'editPasswordForm'=> $form->createView(),
        ]);

    }
}
