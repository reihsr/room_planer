<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RoomReservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Roomreservation controller.
 *
 * @Route("roomreservation")
 */
class RoomReservationController extends Controller
{
    /**
     * Lists all roomReservation entities.
     *
     * @Route("/{date}", name="roomreservation_index", requirements={"date": "\d+-\d+-\d+"})
     * @Method({"GET", "POST"})
     */
    public function indexAction($date = "notset", Request $request)
    {
        if($date == "notset") {
            $date = date("Y-m-d");
        } else {
            $tmpdate = explode("-",$date);
            if(strlen($tmpdate[0]) == 2) {
                $date = $tmpdate[2] . "-" . $tmpdate[1] . "-" . $tmpdate[0];
            }
        }
        
        $em = $this->getDoctrine()->getManager();

        $dayname = date('l', strtotime($date));
        
        $user = $this->getUser();

        $roomDefaultReservations = $em->getRepository('AppBundle:RoomDefaultReservation')->findBy(
            array('day' => $dayname));
            //, 'user' => $user->getUsername()
            
        $roomReservations = $em->getRepository('AppBundle:RoomReservation')->findBy(
            array('date' => $date, 'user' => $user));
        
        $rooms = $em->getRepository('AppBundle:Room')->findAll();
        
        switch ($dayname) {
            case "Monday":
                $dayname = "Montag";
                break;
            case "Tuesday":
                $dayname = "Dienstag";
                break;
            case "Wednesday":
                $dayname = "Mittwoch";
                break;
            case "Thursday":
                $dayname = "Donnerstag";
                break;
            case "Friday":
                $dayname = "Freitag";
                break;
            case "Saturday":
                $dayname = "Samstag";
                break;
            case "Sunday":
                $dayname = "Sonntag";
                break;
        }
        
        $roomReservation = new Roomreservation();
        $form = $this->createForm('AppBundle\Form\RoomReservationType', $roomReservation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Set Status to pending
            $roomReservation->setApproved(-1);
            
            if($roomReservation->getRoomDefaultReservationId() != 0) {
                $roomDefaultReservation = $em->getRepository('AppBundle:RoomDefaultReservation')->findOneById($roomReservation->getRoomDefaultReservationId());
                if($roomDefaultReservation->getStarttime() <= $roomReservation->getStartdatetime() && 
                        $roomDefaultReservation->getEndtime() >= $roomReservation->getEnddatetime() &&
                        $roomDefaultReservation->getRoom() == $roomReservation->getRoom()) {
                    // Set Status to Approved
                    $roomReservation->setApproved(10);
                } elseif($roomDefaultReservation->getRoom() == $roomReservation->getRoom()) {
                    if($roomDefaultReservation->getStarttime() > $roomReservation->getStartdatetime()) {
                        $roomReservationbefore = new Roomreservation();
                        $roomReservationbefore->setStartdatetime($roomReservation->getStartdatetime());
                        $roomReservationbefore->setEnddatetime($roomDefaultReservation->getStarttime());
                        $roomReservationbefore->setRoom($roomReservation->getRoom());
                        $roomReservationbefore->setDate($roomReservation->getDate());
                        $roomReservationbefore->setApproved(-1);
                        $roomReservationbefore->setUser($roomReservation->getUser());
                        $roomReservationbefore->setRoomDefaultReservationId($roomReservation->getRoomDefaultReservationId());
                        
                        $tmpdate = explode("-",$roomReservationbefore->getDate());
                        if(strlen($tmpdate[0]) == 2) {
                            $roomReservationbefore->setDate($tmpdate[2] . "-" . $tmpdate[1] . "-" . $tmpdate[0]);
                        }
            
                        $em->persist($roomReservationbefore);
                        $em->flush($roomReservationbefore);
                        
                        $roomReservation->setStartdatetime($roomDefaultReservation->getStarttime());
                        $roomReservation->setApproved(10);
                    }
                    
                    if($roomDefaultReservation->getEndtime() < $roomReservation->getEnddatetime()) {
                        $roomReservationafter = new Roomreservation();
                        $roomReservationafter->setStartdatetime($roomDefaultReservation->getEndtime());
                        $roomReservationafter->setEnddatetime($roomReservation->getEnddatetime());
                        $roomReservationafter->setRoom($roomReservation->getRoom());
                        $roomReservationafter->setDate($roomReservation->getDate());
                        $roomReservationafter->setApproved(-1);
                        $roomReservationafter->setUser($roomReservation->getUser());
                        $roomReservationafter->setRoomDefaultReservationId($roomReservation->getRoomDefaultReservationId());
                        
                        $tmpdate = explode("-",$roomReservationafter->getDate());
                        if(strlen($tmpdate[0]) == 2) {
                            $roomReservationafter->setDate($tmpdate[2] . "-" . $tmpdate[1] . "-" . $tmpdate[0]);
                        }
            
                        $em->persist($roomReservationafter);
                        $em->flush($roomReservationafter);
                        
                        $roomReservation->setEnddatetime($roomDefaultReservation->getEndtime());
                        $roomReservation->setApproved(10);
                    }
                }
            }
            
            $tmpdate = explode("-",$roomReservation->getDate());
            if(strlen($tmpdate[0]) == 2) {
                $roomReservation->setDate($tmpdate[2] . "-" . $tmpdate[1] . "-" . $tmpdate[0]);
            }
            
            $em->persist($roomReservation);
            $em->flush($roomReservation);
            
            $roomReservations = $em->getRepository('AppBundle:RoomReservation')->findBy(
                array('date' => $date, 'user' => $user));

            $tmpdate = explode("-",$date);
            if(strlen($tmpdate[0]) == 4) {
                $date = $tmpdate[2] . "-" . $tmpdate[1] . "-" . $tmpdate[0];
            }
            return $this->render('roomreservation/index.html.twig', array(
                'roomReservations' => $roomReservations,
                'roomDefaultReservations' => $roomDefaultReservations,
                'date' => $date,
                'nextdate' => date('d-m-Y', strtotime($date . ' +1 day')),
                'previousdate' => date('d-m-Y', strtotime($date . ' -1 day')),
                'nextwdate' => date('d-m-Y', strtotime($date . ' +1 week')),
                'previouswdate' => date('d-m-Y', strtotime($date . ' -1 week')),
                'rooms' => $rooms,
                'dayname' => $dayname,
                'loggedinuser' => $user,
                'roomReservation' => $roomReservation,
                'form' => $form->createView(),
            ));
        }

        $tmpdate = explode("-",$date);
        if(strlen($tmpdate[0]) == 4) {
            $date = $tmpdate[2] . "-" . $tmpdate[1] . "-" . $tmpdate[0];
        }
        return $this->render('roomreservation/index.html.twig', array(
            'roomReservations' => $roomReservations,
            'roomDefaultReservations' => $roomDefaultReservations,
            'date' => $date,
            'nextdate' => date('d-m-Y', strtotime($date . ' +1 day')),
            'previousdate' => date('d-m-Y', strtotime($date . ' -1 day')),
            'nextwdate' => date('d-m-Y', strtotime($date . ' +1 week')),
            'previouswdate' => date('d-m-Y', strtotime($date . ' -1 week')),
            'rooms' => $rooms,
            'dayname' => $dayname,
            'loggedinuser' => $user,
            'roomReservation' => $roomReservation,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * List roomReservation per month and user.
     *
     * @Route("/list/{year}", name="roomreservation_list", requirements={"year": "\d\d\d\d"})
     * @Method("GET")
     */
    public function listAction($year = "notset")
    {
        if($year == "notset") {
            $year = date("Y");
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:RoomReservation');

        $query = $repository->createQueryBuilder('rr')
            ->where('rr.approved = 10 AND rr.date LIKE :year')
            ->setParameter('year', $year . '%')
            ->orderBy('rr.date', 'ASC')
            ->getQuery();

        $roomReservations = $query->getResult();
        
        return $this->render('roomreservation/list.html.twig', array(
            'roomReservations' => $roomReservations
        ));
    }
    
    /**
     * List roomReservation for approvel.
     *
     * @Route("/listapprove", name="roomreservation_list_approve")
     * @Method("GET")
     */
    public function listApprovelAction($year = "notset")
    {
        $em = $this->getDoctrine()->getManager();
        
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:RoomReservation');

        $query = $repository->createQueryBuilder('rr')
            ->where('rr.approved = -1')
            ->orderBy('rr.date', 'ASC')
            ->getQuery();

        $roomReservations = $query->getResult();
        
        return $this->render('roomreservation/approvellist.html.twig', array(
            'roomReservations' => $roomReservations
        ));
    }
    
    /**
     * Update roomReservation approvel state.
     *
     * @Route("/updateapprove", name="roomreservation_update_approve")
     * @Method("POST")
     */
    public function updateApprovelAction(Request $request)
    {   
        $roomreservationid = $request->get('RoomReservationId');
        $approvelstate = $request->get('approvelstate');
        
        $em = $this->getDoctrine()->getManager();
        
        $roomReservation = $em->getRepository('AppBundle:RoomReservation')->findOneById($roomreservationid);
        
        $roomReservation->setApproved($approvelstate);
        
        $em->persist($roomReservation);
        $em->flush($roomReservation);
        
        return $this->render('roomreservation/ajax-response.html.twig', array(
            'roomreservationid' => $roomreservationid,
            'approvelstate' => $approvelstate
        ));
    }

    /**
     * Creates a new roomReservation entity.
     *
     * @Route("/new", name="roomreservation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $roomReservation = new Roomreservation();
        $form = $this->createForm('AppBundle\Form\RoomReservationType', $roomReservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($roomReservation);
            $em->flush($roomReservation);

            return $this->redirectToRoute('roomreservation_show', array('id' => $roomReservation->getId()));
        }

        return $this->render('roomreservation/new.html.twig', array(
            'roomReservation' => $roomReservation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a roomReservation entity.
     *
     * @Route("/{id}", name="roomreservation_show")
     * @Method("GET")
     */
    public function showAction(RoomReservation $roomReservation)
    {
        $deleteForm = $this->createDeleteForm($roomReservation);

        return $this->render('roomreservation/show.html.twig', array(
            'roomReservation' => $roomReservation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing roomReservation entity.
     *
     * @Route("/{id}/edit", name="roomreservation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RoomReservation $roomReservation)
    {
        $deleteForm = $this->createDeleteForm($roomReservation);
        $editForm = $this->createForm('AppBundle\Form\RoomReservationType', $roomReservation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('roomreservation_edit', array('id' => $roomReservation->getId()));
        }

        return $this->render('roomreservation/edit.html.twig', array(
            'roomReservation' => $roomReservation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a roomReservation entity.
     *
     * @Route("/{id}", name="roomreservation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RoomReservation $roomReservation)
    {
        $form = $this->createDeleteForm($roomReservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($roomReservation);
            $em->flush($roomReservation);
        }

        return $this->redirectToRoute('roomreservation_index');
    }

    /**
     * Creates a form to delete a roomReservation entity.
     *
     * @param RoomReservation $roomReservation The roomReservation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RoomReservation $roomReservation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('roomreservation_delete', array('id' => $roomReservation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
