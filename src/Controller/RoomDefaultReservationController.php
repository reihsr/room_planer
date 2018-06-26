<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use App\Entity\RoomDefaultReservation;
use App\Entity\Room;
use App\Entity\User;
use App\Entity\UserExtension;
use Psr\Log\LoggerInterface;
use App\Form\RoomDefaultReservationType;

class RoomDefaultReservationController extends Controller
{
    /**
     * @Route("/admin/templateroomreservation", name="room_default_reservation")
     */
    public function getList()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $roomDefaultReservations = $entityManager->getRepository(RoomDefaultReservation::class)->findAll();
        $rooms = $entityManager->getRepository(Room::class)->findAll();
        $users = $entityManager->getRepository(User::class)->findAll();

        return $this->render('room_default_reservation/index.html.twig', array(
            'roomDefaultReservations' => $roomDefaultReservations,
            'rooms' => $rooms,
            'users' => $users,
            'days' => array(
                'monday' => 'Montag',
                'tuesday' => 'Dienstag',
                'wednesday' => 'Mittwoch',
                'thursday' => 'Donnerstag',
                'friday' => 'Freitag',
                'saturday' => 'Samstag',
                'sunday' => 'Sonntag'
            )
        ));
    }

    /**
     * @Route("/admin/addtemplateroomreservation", name="add_room_default_reservation")
     */
    public function addTemplateReservation(Request $request, LoggerInterface $logger)
    {
        $em = $this->getDoctrine()->getManager();
        $roomDefaultReservations = new RoomDefaultReservation();

        $form = $this->createForm(RoomDefaultReservationType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $roomDefaultReservations->setDayOfTheWeek($form->get('dayOfTheWeek')->getData());
            $roomDefaultReservations->setStartTime($form->get('startTime')->getData()->format('Hi'));
            $roomDefaultReservations->setEndTime($form->get('endTime')->getData()->format('Hi'));
            $roomDefaultReservations->setUserId($form->get('user')->getData()->getId());
            $roomDefaultReservations->setRoomId($form->get('room')->getData()->getId());
            $entityManager->persist($roomDefaultReservations);
            $entityManager->flush();

            return $this->redirectToRoute('room_default_reservation');
        }

        return $this->render('room_default_reservation/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/edittemplateroomreservation", name="edit_room_default_reservation")
     */
    public function editTemplateReservation(Request $request, LoggerInterface $logger)
    {
        $em = $this->getDoctrine()->getManager();
        $roomDefaultReservations = new RoomDefaultReservation();

        $form = $this->createForm(RoomDefaultReservationType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $roomDefaultReservations->setDayOfTheWeek($form->get('dayOfTheWeek')->getData());
            $roomDefaultReservations->setStartTime($form->get('startTime')->getData()->format('Hi'));
            $roomDefaultReservations->setEndTime($form->get('endTime')->getData()->format('Hi'));
            $roomDefaultReservations->setUserId($form->get('user')->getData()->getId());
            $roomDefaultReservations->setRoomId($form->get('room')->getData()->getId());
            $entityManager->persist($roomDefaultReservations);
            $entityManager->flush();

            return $this->redirectToRoute('room_default_reservation');
        }

        return $this->render('room_default_reservation/new.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
