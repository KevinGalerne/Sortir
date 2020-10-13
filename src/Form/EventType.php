<?php

namespace App\Form;

use App\Entity\Event;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',
                  TextType::class,
                       ["attr"=>["class"=>"forminput", "placeholder"=>"Enter your event's name."]])
            ->add('eventDate',
                  DateTimeType::class,
                       ["attr"=>["class"=>"forminput"]])
            ->add('duration',
                  TimeType::class,
                       ["attr"=>["class"=>"forminput"]])
            ->add('subscriptionLimitDate',
                  DateType::class,
                       ["attr"=>["class"=>"forminput"]])
            ->add('maxParticipants',
                  IntegerType::class,
                       ["attr"=>["class"=>"forminput"]])
            ->add('description',
                  TextareaType::class,
                       ["attr"=>["class"=>"forminput", "placeholder"=>"Enter a description of the event."]])
            ->add('ville',
                  EntityType::class,
                       ["class"=>"App\Entity\City", "choice_label"=>"name"])
            ->add('lieu',
                  EntityType::class,
                       ["class"=>"App\Entity\Place", "choice_label"=>"name"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
