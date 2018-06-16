<?php
// src/AppBundle/Form/Type/DaySelectType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DaySelectType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'choices'  => array(
                    'Montag' => 'monday',
                    'Dienstag' => 'tuesday',
                    'Mittwoch' => 'wednesday',
                    'Donnerstag' => 'thursday',
                    'Freitag' => 'friday',
                    'Samstag' => 'saturday',
                    'Sonntag' => 'sunday'
            )
        ));
    }
    
    public function getParent()
    {
        return ChoiceType::class;
    }
}