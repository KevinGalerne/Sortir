<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ["attr" => ["class" => "forminput"]])
            ->add('pseudo', TextType::class, ["attr" => ["class" => "forminput"]] )
            ->add('lastName', TextType::class, ["attr" => ["class" => "forminput"]])
            ->add('firstName', TextType::class, ["attr" => ["class" => "forminput"]])
            ->add('phoneNumber', TelType::class, ["attr" => ["class" => "forminput"]])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
