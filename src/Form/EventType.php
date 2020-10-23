<?php

namespace App\Form;

use App\Entity\Event;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $today = new \DateTime('now');
        $builder
            ->add('name',
                TextType::class,
                ["attr" => ["class" => "forminput", "placeholder" => "Entrez le nom de la sortie."]])
            ->add('eventDate',
                DateTimeType::class,
                ['attr' => ['min' => $today->format('Y-m-d H:i:s')],
                    "data" => new \DateTime('now')])
            ->add('duration',
                TimeType::class,
                ["placeholder" => [
                    "hour" => "Heures",
                    "minute" => "Minutes"
                ]])
            ->add('subscriptionLimitDate',
                DateTimeType::class,
                ['attr' => ['min' => $today->format('Y-m-d H:i:s')],
                    "data" => new \DateTime('now')])
            ->add('maxParticipants',
                IntegerType::class,
                ["attr" => ["class" => "forminput", 'min' => 0]])
            ->add('description',
                TextareaType::class,
                ["attr" => ["class" => "eventdescription", "placeholder" => "Entrez une description de la sortie."]])
            ->add('save',
                SubmitType::class,
                ['label' => 'Enregistrer',
                    "attr" => ["class" => "sortir_buttons"]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
