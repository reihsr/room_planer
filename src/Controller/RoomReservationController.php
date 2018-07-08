<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RoomReservationController extends Controller
{
    /**
     * @Route("/room/reservation", name="room_reservation")
     */
    public function index()
    {
        return $this->render('room_reservation/index.html.twig', [
            'controller_name' => 'RoomReservationController',
        ]);
    }
}
