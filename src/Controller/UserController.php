<?php

namespace App\Controller;

use App\Form\EditAccountType;
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
        }
        return $this->render('user/account_edit.html.twig', [
            'editForm'=> $form->createView(),
            'user'=> $user
        ]);
    }
}
