<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RoomDefaultReservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Roomdefaultreservation controller.
 *
 * @Route("roomdefaultreservation")
 */
class RoomDefaultReservationController extends Controller
{
    /**
     * Lists all roomDefaultReservation entities.
     *
     * @Route("/", name="roomdefaultreservation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $roomDefaultReservations = $em->getRepository('AppBundle:RoomDefaultReservation')->findAll();
        $rooms = $em->getRepository('AppBundle:Room')->findAll();

        return $this->render('roomdefaultreservation/index.html.twig', array(
            'roomDefaultReservations' => $roomDefaultReservations, 
            'rooms' => $rooms, 
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
     * Creates a new roomDefaultReservation entity.
     *
     * @Route("/new", name="roomdefaultreservation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $roomDefaultReservation = new Roomdefaultreservation();
        $form = $this->createForm('AppBundle\Form\RoomDefaultReservationType', $roomDefaultReservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($roomDefaultReservation);
            $em->flush($roomDefaultReservation);

            return $this->redirectToRoute('roomdefaultreservation_show', array('id' => $roomDefaultReservation->getId()));
        }

        return $this->render('roomdefaultreservation/new.html.twig', array(
            'roomDefaultReservation' => $roomDefaultReservation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a roomDefaultReservation entity.
     *
     * @Route("/{id}", name="roomdefaultreservation_show")
     * @Method("GET")
     */
    public function showAction(RoomDefaultReservation $roomDefaultReservation)
    {
        $deleteForm = $this->createDeleteForm($roomDefaultReservation);

        return $this->render('roomdefaultreservation/show.html.twig', array(
            'roomDefaultReservation' => $roomDefaultReservation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing roomDefaultReservation entity.
     *
     * @Route("/{id}/edit", name="roomdefaultreservation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RoomDefaultReservation $roomDefaultReservation)
    {
        $deleteForm = $this->createDeleteForm($roomDefaultReservation);
        $editForm = $this->createForm('AppBundle\Form\RoomDefaultReservationType', $roomDefaultReservation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('roomdefaultreservation_edit', array('id' => $roomDefaultReservation->getId()));
        }

        return $this->render('roomdefaultreservation/edit.html.twig', array(
            'roomDefaultReservation' => $roomDefaultReservation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a roomDefaultReservation entity.
     *
     * @Route("/{id}", name="roomdefaultreservation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RoomDefaultReservation $roomDefaultReservation)
    {
        $form = $this->createDeleteForm($roomDefaultReservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($roomDefaultReservation);
            $em->flush($roomDefaultReservation);
        }

        return $this->redirectToRoute('roomdefaultreservation_index');
    }

    /**
     * Creates a form to delete a roomDefaultReservation entity.
     *
     * @param RoomDefaultReservation $roomDefaultReservation The roomDefaultReservation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RoomDefaultReservation $roomDefaultReservation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('roomdefaultreservation_delete', array('id' => $roomDefaultReservation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
