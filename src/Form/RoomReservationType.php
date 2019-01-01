<?php

namespace App\Form;

use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\RoomReservation;
use App\Entity\Room;
use App\Entity\UserExtension;

class RoomReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, array('class' => UserExtension::class,'choice_label' => 'fullName'))
            ->add('room', EntityType::class, array('class' => Room::class,'choice_label' => 'roomName'))
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'years'  => array(
                    '2018',
                    '2019'
                )))
            ->add('startTime', TimeType::class)
            ->add('endTime', TimeType::class)
            ->add('reservationTemplate', HiddenType::class)
            ->add('approved', HiddenType::class)
            ->add('saved', HiddenType::class)
            ->add('reservationId', HiddenType::class)
            ->add('reserv', SubmitType::class, array('label' => 'Reservieren',
                'attr' => array('class' => 'btn btn-sm btn-primary btn-block')))
            ->add('edit', SubmitType::class, array('label' => 'Bearbeiten',
                'attr' => array('class' => 'btn btn-sm btn-success btn-block')))
            ->add('delete', SubmitType::class, array('label' => 'Löschen',
                'attr' => array('class' => 'btn btn-sm btn-danger btn-block')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
