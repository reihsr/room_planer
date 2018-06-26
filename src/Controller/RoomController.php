<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Room;
use Psr\Log\LoggerInterface;

class RoomController extends Controller
{
    /**
     * @Route("/rooms", name="rooms")
     */
    public function getRooms()
    {
        $repository = $this->getDoctrine()->getRepository(Room::class);

        $rooms = $repository->findAll();
        return $this->render('room/list.html.twig', [
            'controller_name' => 'RoomController',
            'rooms' => $rooms
        ]);
    }

    /**
     * @Route("/admin/newroom", name="newroom")
     */
    public function addRoom(Request $request, LoggerInterface $logger)
    {
        $room = new Room();
        $form = $this->createFormBuilder($room)
            ->add('roomName', TextType::class)
            ->add('description', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('rooms');
        }

        return $this->render('room/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/editroom/{id}", name="editroom")
     */
    public function editRoom($id, Request $request, LoggerInterface $logger)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $room = $entityManager->getRepository(Room::class)->find($id);
        $form = $this->createFormBuilder($room)
            ->add('roomName', TextType::class)
            ->add('description', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('rooms');
        }

        return $this->render('room/edit.html.twig', [
            'form' => $form->createView(),
            'room' => $room
        ]);
    }
}
