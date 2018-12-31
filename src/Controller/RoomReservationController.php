<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use App\Entity\RoomReservation;
use App\Entity\RoomDefaultReservation;
use App\Entity\Room;
use App\Entity\User;
use App\Entity\UserExtension;
use App\Form\RoomReservationType;

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

    /**
     * @Route("/room/addreservation/{reservationtemplate}", name="add_room_reservation")
     */
    public function addReservation(Request $request, LoggerInterface $logger) {
        $roomReservations = new RoomReservation();

        $form = $this->createForm(RoomReservationType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Set status of approval to pending (-1)
            $roomReservations->setApproved(-1);

            // Set data elements
            $roomReservations->setDate($form->get('date')->getData());
            $roomReservations->setStartTime($form->get('startTime')->getData()->format('Hi'));
            $roomReservations->setEndTime($form->get('endTime')->getData()->format('Hi'));
            $roomReservations->setUserId($form->get('user')->getData()->getId());
            $roomReservations->setRoomId($form->get('room')->getData()->getId());


            // Handler if no template is used
            if($form->get('reservationTemplate')->getData() == '') {
                $roomReservations->setRoomDefaultReservationId(-1);
                $entityManager->persist($roomReservations);
                $entityManager->flush();
            } else {
                // Get the reservation template
                $roomReservationTemplate = $entityManager->getRepository(RoomDefaultReservation::class)->findOneById($form->get('reservationTemplate')->getData());
                $roomReservations->setRoomDefaultReservationId($form->get('reservationTemplate')->getData());

                // Check if everything is in the correct time slot and room
                if($roomReservationTemplate->getStartTime       <= $form->get('startTime')->getData()->format('Hi') &&
                        $roomReservationTemplate->getEndTime    >= $form->get('endTime')->getData()->format('Hi') &&
                        $roomReservationTemplate->getRoom       == $form->get('room')->getData()->getId()) {

                    $roomReservations->setApproved(10);
                    $entityManager->persist($roomReservations);
                    $entityManager->flush();

                    return $this->redirectToRoute('room_reservation');
                } else { // Timeslot and/or room need approval
                    if ($roomReservationTemplate->getRoom == $form->get('room')->getData()->getId()) {
                        // Check and create a request for times before the template slot
                        if ($roomReservationTemplate->getStartTime > $form->get('startTime')->getData()->format('Hi')) {
                            $roomReservationBefore = new RoomReservation();
                            $roomReservationBefore->setApproved(-1);
                            $roomReservationBefore->setDate($form->get('date')->getData());
                            $roomReservationBefore->setStartTime($form->get('startTime')->getData()->format('Hi'));
                            $roomReservationBefore->setEndTime($form->get('endTime')->getData()->format('Hi'));
                            $roomReservationBefore->setUserId($form->get('user')->getData()->getId());
                            $roomReservationBefore->setRoomId($form->get('room')->getData()->getId());
                            $roomReservationBefore->setRoomDefaultReservationId(
                                $form->get('reservationTemplate')->getData()
                            );
                            $entityManager->persist($roomReservationBefore);
                            $entityManager->flush();
                            $roomReservations->setStartTime($roomReservationTemplate->getStartTime);
                        }
                        // Check and create a request for times after the template slot
                        if ($roomReservationTemplate->getEndTime < $form->get('endTime')->getData()->format('Hi')) {
                            $roomReservationAfter = new RoomReservation();
                            $roomReservationAfter->setApproved(-1);
                            $roomReservationAfter->setDate($form->get('date')->getData());
                            $roomReservationAfter->setStartTime($form->get('startTime')->getData()->format('Hi'));
                            $roomReservationAfter->setEndTime($form->get('endTime')->getData()->format('Hi'));
                            $roomReservationAfter->setUserId($form->get('user')->getData()->getId());
                            $roomReservationAfter->setRoomId($form->get('room')->getData()->getId());
                            $roomReservationAfter->setRoomDefaultReservationId(
                                $form->get('reservationTemplate')->getData()
                            );
                            $entityManager->persist($roomReservationAfter);
                            $entityManager->flush();
                            $roomReservations->setEndTime($roomReservationTemplate->getEndTime);
                        }
                        // Safe the reservation with the approved times
                        $roomReservations->setApproved(10);
                        $entityManager->persist($roomReservations);
                        $entityManager->flush();
                    } else { // Room has changed, so has to bee approved, no time check needed
                        $roomReservations->setApproved(-1);
                        $entityManager->persist($roomReservations);
                        $entityManager->flush();
                    }
                }
            }
            return $this->redirectToRoute('room_reservation');
        }

        //TODO:
        // Set Form date if template given

        return $this->render('room_reservation/new.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
