<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use App\Entity\RoomDefaultReservation;
use App\Entity\Room;
use App\Entity\UserExtension;

class RoomDefaultReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, array('class' => UserExtension::class,'choice_label' => 'fullName'))
            ->add('room', EntityType::class, array('class' => Room::class,'choice_label' => 'roomName'))
            ->add('dayOfTheWeek', ChoiceType::class,
                array('choices'  => array(
                    'Montag'=>'Montag',
                    'Dienstag'=>'Dienstag',
                    'Mittwoch'=>'Mittwoch',
                    'Donnerstag'=>'Donnerstag',
                    'Freitag'=>'Freitag',
                    'Samstag'=>'Samstag',
                    'Sonntag'=>'Sonntag'
                )))
            ->add('startTime', TimeType::class)
            ->add('endTime', TimeType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
