<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountContollerController extends AbstractController
{
    /**
     * @Route("/account/contoller", name="account_contoller")
     */
    public function index()
    {
        return $this->render('account_contoller/index.html.twig', [
            'controller_name' => 'AccountContollerController',
        ]);
    }
}
