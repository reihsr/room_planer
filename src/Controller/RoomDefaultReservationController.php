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
use Symfony\Component\Validator\Constraints\DateTime;

class RoomDefaultReservationController extends Controller
{
    /**
     * @Route("/admin/templateroomreservation", name="room_default_reservation")
     */
    public function getList()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $roomDefaultReservations = $entityManager->getRepository(RoomDefaultReservation::class)->findAll();
        $rooms_tmp = $entityManager->getRepository(Room::class)->findAll();
        $rooms = array();
        foreach ($rooms_tmp as $room) {
            $rooms[$room->getId()] = $room;
        }
        $users_tmp = $entityManager->getRepository(User::class)->findAll();
        $users = array();
        $user_reservations = array();
        foreach ($users_tmp as $user) {
            $users[$user->getId()] = $user;
            $user_reservations[$user->getId()] = array();
        }
        $usersex_tmp = $entityManager->getRepository(UserExtension::class)->findAll();
        $usersex = array();
        foreach ($usersex_tmp as $userex) {
            $usersex[$userex->getUsername()] = $userex;
        }
        foreach ($roomDefaultReservations as $roomDefaultReservation) {
            $user_reservations[$roomDefaultReservation->getUserId()][$roomDefaultReservation->getId()] = $roomDefaultReservation;
        }




        return $this->render('room_default_reservation/index.html.twig', array(
            'roomDefaultReservations' => $roomDefaultReservations,
            'rooms' => $rooms,
            'users' => $users,
            'usersex' => $usersex,
            'user_reservations' => $user_reservations,
            'days' => array(
                'Montag'=>'Montag',
                'Dienstag'=>'Dienstag',
                'Mittwoch'=>'Mittwoch',
                'Donnerstag'=>'Donnerstag',
                'Freitag'=>'Freitag',
                'Samstag'=>'Samstag',
                'Sonntag'=>'Sonntag'
            )
        ));
    }

    /**
     * @Route("/admin/addtemplateroomreservation", name="add_room_default_reservation")
     */
    public function addTemplateReservation(Request $request, LoggerInterface $logger)
    {
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
     * @Route("/admin/edittemplateroomreservation/{id}", name="edit_room_default_reservation")
     */
    public function editTemplateReservation($id, Request $request, LoggerInterface $logger)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $roomDefaultReservations = $entityManager->getRepository(RoomDefaultReservation::class)->find($id);

        $form = $this->createForm(RoomDefaultReservationType::class);
        $form->get('dayOfTheWeek')->setData($roomDefaultReservations->getDayOfTheWeek());
        $startTime = new \DateTime(substr_replace(sprintf("%04d", $roomDefaultReservations->getStartTime()), ':', 2, 0));
        $form->get('startTime')->setData($startTime);
        $endTime = new \DateTime(substr_replace(sprintf("%04d", $roomDefaultReservations->getEndTime()), ':', 2, 0));
        $form->get('endTime')->setData($endTime);
        $form->get('user')->setData($roomDefaultReservations->getUserId());
        $form->get('room')->setData($roomDefaultReservations->getRoomId());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $roomDefaultReservations->setDayOfTheWeek($form->get('dayOfTheWeek')->getData());
            $roomDefaultReservations->setStartTime($form->get('startTime')->getData()->format('Hi'));
            $roomDefaultReservations->setEndTime($form->get('endTime')->getData()->format('Hi'));
            $roomDefaultReservations->setUserId($form->get('user')->getData()->getId());
            $roomDefaultReservations->setRoomId($form->get('room')->getData()->getId());
            $entityManager->persist($roomDefaultReservations);
            $entityManager->flush();

            return $this->redirectToRoute('room_default_reservation');
        }

        return $this->render('room_default_reservation/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
