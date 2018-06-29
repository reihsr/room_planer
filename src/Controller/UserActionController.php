<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserActionController extends Controller
{
    /**
     * @Route("/user/action", name="user_action")
     */
    public function index()
    {
        return $this->render('user_action/index.html.twig', [
            'controller_name' => 'UserActionController',
        ]);
    }
}
