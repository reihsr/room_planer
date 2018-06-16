<?php
// src/AppBundle/Form/Type/TimeSelectType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TimeSelectType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        /*$data = array();
        for($hour = 6; $hour <= 23; $hour++) {
            for($minute = 0; $minute <= 3; $minute++) {
                $data[($hour * 100) + ($minute * 3)] =  $hour + ":" + ($minute * 3);
            }
        }*/
        $resolver->setDefaults(array(
            'choices'  => array(
                '06:00' => '600',
                '06:15' => '615',
                '06:30' => '630',
                '06:45' => '645',
                '07:00' => '700',
                '07:15' => '715',
                '07:30' => '730',
                '07:45' => '745',
                '08:00' => '800',
                '08:15' => '815',
                '08:30' => '830',
                '08:45' => '845',
                '09:00' => '900',
                '09:15' => '915',
                '09:30' => '930',
                '09:45' => '945',
                '10:00' => '1000',
                '10:15' => '1015',
                '10:30' => '1030',
                '10:45' => '1045',
                '11:00' => '1100',
                '11:15' => '1115',
                '11:30' => '1130',
                '11:45' => '1145',
                '12:00' => '1200',
                '12:15' => '1215',
                '12:30' => '1230',
                '12:45' => '1245',
                '13:00' => '1300',
                '13:15' => '1315',
                '13:30' => '1330',
                '13:45' => '1345',
                '14:00' => '1400',
                '14:15' => '1415',
                '14:30' => '1430',
                '14:45' => '1445',
                '15:00' => '1500',
                '15:15' => '1515',
                '15:30' => '1530',
                '15:45' => '1545',
                '16:00' => '1600',
                '16:15' => '1615',
                '16:30' => '1630',
                '16:45' => '1645',
                '17:00' => '1700',
                '17:15' => '1715',
                '17:30' => '1730',
                '17:45' => '1745',
            )
        ));
    }
    
    public function getParent()
    {
        return ChoiceType::class;
    }
}