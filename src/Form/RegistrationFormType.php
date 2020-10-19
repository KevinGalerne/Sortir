<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('email', EmailType::class, ["attr" => ["class" => "forminput"]])
            ->add('pseudo', TextType::class, ["attr" => ["class" => "forminput"]])
            ->add('firstName', TextType::class, ["attr" => ["class" => "forminput"]])
            ->add('lastName', TextType::class, ["attr" => ["class" => "forminput"]])
            ->add('phoneNumber', TelType::class, ["attr" => ["class" => "forminput"]])


            ->add('plainPassword', RepeatedType::class, [


                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne sont pas identiques',
                'options' =>  ['attr' => ['class' => 'forminput']],
                'required' => true,
                'first_options'  => ['label' => ' '],
                'second_options' => ['label' => ' '],
                        'mapped' => false,
                      'constraints' => [
                        new NotBlank([
                            'message' => 'Saissez un mot de passe',
                        ]),
                        new Length([
                            'min' => 8,
                            'minMessage' => 'Votre mot de passe doit mesurer au moins 8 caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                    ]),

                         ]

            ])


            ->add('roles', ChoiceType::class,  ["multiple" => true, "attr" => ["class" => "forminput"],  "choices" => [
                "Administrateur" => "ROLE_ADMIN",
                "Utilisateur" => "ROLE_STUDENT",
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
