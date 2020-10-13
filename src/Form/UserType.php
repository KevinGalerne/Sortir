<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userName', null, ["attr" => ["class"=>"forminput"]])
            ->add('firstName', null, ["attr" => ["class"=>"forminput"]])
            ->add('lastName', null, ["attr" => ["class"=>"forminput"]])
            ->add('phoneNumber', null, ["attr" => ["class" => "forminput"]])
            ->add('email', EmailType::class, ["attr" => ["class" => "forminput"]])
            ->add('password', null, ["attr" => ["class"=> "forminput"]])
            ->add('passwordConfirmation', null, ["attr" => ["class" => "forminput"]])
            ->add("campus", EntityType::class, ["attr"=>["class"=>"forminput"],"class"=>"App\Entity\Campus", "choice_label"=>"name" ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('cancel', SubmitType::class, ['label' => 'Annuler'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
