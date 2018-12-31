<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use App\Entity\RoomReservation;
use App\Entity\RoomDefaultReservation;
use App\Entity\Room;
use App\Entity\User;
use App\Entity\UserExtension;
use App\Form\RoomReservationType;

class DashboardController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(Request $request, UserInterface $user = null, LoggerInterface $logger)
    {
        if($user == null) {
            return $this->render('login');
        }

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(RoomReservationType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $roomReservations = new RoomReservation();
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
                if($roomReservationTemplate->getStartTime()       <= $form->get('startTime')->getData()->format('Hi') &&
                    $roomReservationTemplate->getEndTime()    >= $form->get('endTime')->getData()->format('Hi') &&
                    $roomReservationTemplate->getRoomId()       == $form->get('room')->getData()->getId()) {

                    $roomReservations->setApproved(10);
                    $entityManager->persist($roomReservations);
                    $entityManager->flush();

                } else { // Timeslot and/or room need approval
                    if ($roomReservationTemplate->getRoomId() == $form->get('room')->getData()->getId()) {
                        // Check and create a request for times before the template slot
                        if ($roomReservationTemplate->getStartTime() > $form->get('startTime')->getData()->format('Hi')) {
                            $roomReservationBefore = new RoomReservation();
                            $roomReservationBefore->setApproved(-1);
                            $roomReservationBefore->setDate($form->get('date')->getData());
                            $roomReservationBefore->setStartTime($form->get('startTime')->getData()->format('Hi'));
                            $roomReservationBefore->setEndTime($roomReservationTemplate->getStartTime());
                            $roomReservationBefore->setUserId($form->get('user')->getData()->getId());
                            $roomReservationBefore->setRoomId($form->get('room')->getData()->getId());
                            $roomReservationBefore->setRoomDefaultReservationId(
                                $form->get('reservationTemplate')->getData()
                            );
                            $entityManager->persist($roomReservationBefore);
                            $entityManager->flush();
                            $roomReservations->setStartTime($roomReservationTemplate->getStartTime());
                        }
                        // Check and create a request for times after the template slot
                        if ($roomReservationTemplate->getEndTime() < $form->get('endTime')->getData()->format('Hi')) {
                            $roomReservationAfter = new RoomReservation();
                            $roomReservationAfter->setApproved(-1);
                            $roomReservationAfter->setDate($form->get('date')->getData());
                            $roomReservationAfter->setStartTime($roomReservationTemplate->getEndTime());
                            $roomReservationAfter->setEndTime($form->get('endTime')->getData()->format('Hi'));
                            $roomReservationAfter->setUserId($form->get('user')->getData()->getId());
                            $roomReservationAfter->setRoomId($form->get('room')->getData()->getId());
                            $roomReservationAfter->setRoomDefaultReservationId(
                                $form->get('reservationTemplate')->getData()
                            );
                            $entityManager->persist($roomReservationAfter);
                            $entityManager->flush();
                            $roomReservations->setEndTime($roomReservationTemplate->getEndTime());
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
        }

        // Change date formating
        $date_now = date("d.m.Y");
        $date_displayend = date("d.m.Y", strtotime("+6 weeks", strtotime($date_now)));


        $user_object = $entityManager->getRepository(User::class)->findOneBy(array('username' => $user->getUsername()));
        $reservation_templates = $entityManager->getRepository(RoomDefaultReservation::class)->
                    findBy(array('userId' => $user_object->getId()));
        $reservation = $entityManager->getRepository(RoomReservation::class)->findAllForUserWithDate($user_object->getId(),
            date("Y-m-d"), date("Y-m-d", strtotime("+6 weeks", strtotime($date_now))));

        $reservation_array = array();
        for($reservation_counter = 0; $reservation_counter < count($reservation); $reservation_counter++) {
            if(!array_key_exists($reservation[$reservation_counter]->getDate()->format('Y-m-d'), $reservation_array)) {
                $reservation_array[$reservation[$reservation_counter]->getDate()->format('Y-m-d')] = array();
            }
            $reservation_array[$reservation[$reservation_counter]->getDate()->format('Y-m-d')][count($reservation_array[$reservation[$reservation_counter]->getDate()->format('Y-m-d')])] = $reservation[$reservation_counter];
        }

        $userExtension = $entityManager->getRepository(UserExtension::class)->findOneBy(array('username' => $user->getUsername()));

        $form_array = array();
        $array_counter = 0;
        $day_counter = 0;

        $day_array = array("Mon" =>array(), "Tue" =>array(), "Wed" =>array(), "Thu" =>array(), "Fri" =>array(), "Sat" =>array(), "Sun" =>array());
        for($template_counter = 0; $template_counter < count($reservation_templates); $template_counter++) {
            if($reservation_templates[$template_counter]->getDayOfTheWeek() == 'Montag') {
                $day_array["Mon"][count($day_array["Mon"])] = $template_counter;
            } elseif ($reservation_templates[$template_counter]->getDayOfTheWeek() == 'Dienstag') {
                $day_array["Tue"][count($day_array["Tue"])] = $template_counter;
            } elseif ($reservation_templates[$template_counter]->getDayOfTheWeek() == 'Mittwoch') {
                $day_array["Wed"][count($day_array["Wed"])] = $template_counter;
            } elseif ($reservation_templates[$template_counter]->getDayOfTheWeek() == 'Donnerstag') {
                $day_array["Thu"][count($day_array["Thu"])] = $template_counter;
            } elseif ($reservation_templates[$template_counter]->getDayOfTheWeek() == 'Freitag') {
                $day_array["Fri"][count($day_array["Fri"])] = $template_counter;
            } elseif ($reservation_templates[$template_counter]->getDayOfTheWeek() == 'Samstag') {
                $day_array["Sat"][count($day_array["Sat"])] = $template_counter;
            } elseif ($reservation_templates[$template_counter]->getDayOfTheWeek() == 'Sonntag') {
                $day_array["Sun"][count($day_array["Sun"])] = $template_counter;
            }
        }

        $time_start = 0;

        $startdate = strtotime($date_now);
        $enddate = strtotime($date_displayend);

        while ($startdate < $enddate) {
            $day_working = date("D", strtotime("+" . $day_counter . " days", strtotime($date_now)));
            $date_working = date("d.m.Y", strtotime("+" . $day_counter . " days", strtotime($date_now)));
            $startdate = strtotime($date_working);

            if(array_key_exists(date("Y-m-d", strtotime("+" . $day_counter . " days", strtotime($date_now))), $reservation_array)) {
                foreach($reservation_array[date("Y-m-d", strtotime("+" . $day_counter . " days", strtotime($date_now)))] as $values) {
                    $reservation_tmp = $values;
                    $room = $entityManager->getRepository(Room::class)->find($reservation_tmp->getRoomId());
                    $form = $this->createForm(RoomReservationType::class);
                    $form->get('date')->setData(\DateTime::createFromFormat('d.m.Y',$date_working));
                    $form->get('user')->setData($userExtension);
                    $form->get('room')->setData($room);
                    $startTime = new \DateTime(substr_replace(sprintf("%04d", $reservation_tmp->getStartTime()), ':', 2, 0));
                    $form->get('startTime')->setData($startTime);
                    $endTime = new \DateTime(substr_replace(sprintf("%04d", $reservation_tmp->getEndTime()), ':', 2, 0));
                    $form->get('endTime')->setData($endTime);
                    $form->get('reservationTemplate')->setData($reservation_tmp->getRoomDefaultReservationId());
                    $form->get('saved')->setData('saved');
                    $form->get('approved')->setData($reservation_tmp->getApproved());
                    $form_array[$array_counter] = $form->createView();
                    $array_counter++;
                }
            }
            foreach($day_array[$day_working] as &$valuesnew) {
                $reservation_template = $reservation_templates[$valuesnew];
                $room = $entityManager->getRepository(Room::class)->find($reservation_template->getRoomId());
                $form = $this->createForm(RoomReservationType::class);
                $form->get('date')->setData(\DateTime::createFromFormat('d.m.Y',$date_working));
                $form->get('user')->setData($userExtension);
                $form->get('room')->setData($room);
                $startTime = new \DateTime(substr_replace(sprintf("%04d", $reservation_template->getStartTime()), ':', 2, 0));
                $form->get('startTime')->setData($startTime);
                $endTime = new \DateTime(substr_replace(sprintf("%04d", $reservation_template->getEndTime()), ':', 2, 0));
                $form->get('endTime')->setData($endTime);
                $form->get('reservationTemplate')->setData($reservation_template->getId());
                $form->get('saved')->setData('notsaved');
                $form_array[$array_counter] = $form->createView();
                $array_counter++;
            }
            $day_counter++;
        }

        $logger->debug("Step3: " . date("H:i:s"));

        return $this->render('dashboard/index.html.twig', [
            'date_now' => $date_now,
            'date_end' => $date_displayend,
            'number' => count($reservation),
            'form_array' => $form_array,
            'reservation_templates' => $reservation_templates,
            'reservation' => $reservation
        ]);
    }
}
