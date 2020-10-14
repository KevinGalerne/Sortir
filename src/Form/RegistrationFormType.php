<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, ["attr" => ["class" => "forminput"]])
            ->add('userName', null, ["attr" => ["class" => "forminput"]])
            ->add('firstName', null, ["attr" => ["class" => "forminput"]])
            ->add('lastName', null, ["attr" => ["class" => "forminput"]])
            ->add('phoneNumber', null, ["attr" => ["class" => "forminput"]])
            ->add('plainPassword', PasswordType::class, ["attr" => ["class" => "forminput"],
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Saissez un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit mesurer au moins 8 caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class,["multiple"=>true,"attr" => ["class" => "forminput"],"choices" => [
                "Administrateur" => "ROLE_ADMIN",
                "Utilisateur" => "ROLE_USER",
            ]])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->add("campus", EntityType::class, ["attr" => ["class" => "forminput"], "class" => "App\Entity\Campus", "choice_label" => "name"]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
