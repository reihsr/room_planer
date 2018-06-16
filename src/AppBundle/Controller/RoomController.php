<?php
// src/AppBundle/Controller/RoomController.php
namespace AppBundle\Controller;

use AppBundle\Form\RoomType;
use AppBundle\Entity\Room;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class RoomController extends Controller
{
    /**
     * @Route("/room/registration", name="room_registration")
     */
    public function registrationAction(Request $request){
        // 1) build the form
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($room);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('room_list');
        }

        return $this->render(
            'room/room_registration.html.twig',
            array('form' => $form->createView())
        );
    }
    
    /**
     * @Route("/room/list", name="room_list")
     */
    public function listAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Room');
        $rooms = $repository->findAll();

        return $this->render('room/room_list.html.twig', 
            array('rooms' => $rooms)
        );
    }
}