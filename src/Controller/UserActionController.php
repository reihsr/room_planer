<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\RoomDefaultReservation;
use App\Entity\Room;
use App\Entity\User;
use App\Entity\UserExtension;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserActionController extends Controller
{
    /**
     * @Route("/admin/users", name="user_action")
     */
    public function index()
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

        return $this->render('user_action/index.html.twig', array(
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
        return $this->render('user_action/index.html.twig', [
            'controller_name' => 'UserActionController',
        ]);
    }

    /**
     * @Route("/admin/newuser", name="new_user_action")
     */
    public function addUser(Request $request, LoggerInterface $logger, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $userExtension = new UserExtension();

        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $logger->info("!!!!!!!!!!!!!!!!!!!!!!!!!FullName");
            $logger->info($form->get('fullname')->getData());

            $userExtension->setUsername($form->get('username')->getData());
            $userExtension->setFullName($form->get('fullname')->getData());

            $user->setUsername($form->get('username')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setIsActive($form->get('isActive')->getData());
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $entityManager->persist($user);
            $entityManager->persist($userExtension);
            $entityManager->flush();

            return $this->redirectToRoute('user_action');
        }

        return $this->render('user_action/new.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
