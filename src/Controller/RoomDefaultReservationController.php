<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RoomDefaultReservationController extends Controller
{
    /**
     * @Route("/room/default/reservation", name="room_default_reservation")
     */
    public function index()
    {
        return $this->render('room_default_reservation/index.html.twig', [
            'controller_name' => 'RoomDefaultReservationController',
        ]);
    }
}
