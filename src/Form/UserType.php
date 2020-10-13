<?php

namespace App\Form;

use App\Entity\User;
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
            ->add('username', null, ["attr" => ["class"=>"forminput"]])
            ->add('firstname', null, ["attr" => ["class"=>"forminput"]])
            ->add('name', null, ["attr" => ["class"=>"forminput"]])
            ->add('phonenumber', null, ["attr" => ["class" => "forminput"]])
            ->add('email', EmailType::class, ["attr" => ["class" => "forminput"]])
            ->add('password', null, ["attr" => ["class"=> "forminput"]])
            ->add('passwordconfirmation', null, ["attr" => ["class" => "forminput"]])
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
