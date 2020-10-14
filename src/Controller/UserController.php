<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function editAccount()
    {
        return $this->render('user/account_edit.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
