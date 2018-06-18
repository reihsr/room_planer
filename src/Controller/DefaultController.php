<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    /**
     * @Route("/default", name="default")
     */
    public function index(LoggerInterface $logger)
    {
        $logger->info("DefaultController!");
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/datenschutzerklaerung", name="datenschutzerklaerung")
     */
    public function indexDatenschutzerklaerung()
    {
        return $this->render('default/datenschutzerklaerung.html.twig', [
        ]);
    }
}
