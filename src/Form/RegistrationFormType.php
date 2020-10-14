<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
<<<<<<< HEAD
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

=======
>>>>>>> c62bbe19959762d5f86aa16b12b96e4470fc3795
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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

<<<<<<< HEAD
            ->add('email',EmailType::class, ["attr" => ["class"=>"forminput"]])
            ->add('pseudo', TextType::class, ["attr" => ["class"=>"forminput"]])
            ->add('firstName', TextType::class, ["attr" => ["class"=>"forminput"]])
            ->add('lastName', TextType::class, ["attr" => ["class"=>"forminput"]])
            ->add('phoneNumber', TelType::class, ["attr" => ["class" => "forminput"]])
            ->add('plainPassword', PasswordType::class, ["attr" => ["class"=>"forminput"],
=======
            ->add('email', EmailType::class, ["attr" => ["class" => "forminput"]])
            ->add('pseudo', TextType::class, ["attr" => ["class" => "forminput"]])
            ->add('firstName', TextType::class, ["attr" => ["class" => "forminput"]])
            ->add('lastName', TextType::class, ["attr" => ["class" => "forminput"]])
            ->add('phoneNumber', TelType::class, ["attr" => ["class" => "forminput"]])
            ->add('plainPassword', PasswordType::class, ["attr" => ["class" => "forminput"],
>>>>>>> c62bbe19959762d5f86aa16b12b96e4470fc3795

                // instead of being set onto the object directly,
                // this is read and encoded in the controller
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
                ],
            ])
<<<<<<< HEAD

            ->add('roles', ChoiceType::class,["multiple"=>true,"attr" => ["class" => "forminput"],"choices" => [
                "Administrateur" => "ROLE_ADMIN",
                "Utilisateur" => "ROLE_USER",
            ]])

            ->add('passwordConfirmation', PasswordType::class, ["attr" => ["class" => "forminput"]])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->add("campus", EntityType::class, ["attr"=>["class"=>"forminput"],"class"=>"App\Entity\Campus", "choice_label"=>"name" ]);
=======
            ->add('roles', ChoiceType::class, ["multiple" => true, "attr" => ["class" => "forminput"], "choices" => [
                "Administrateur" => "ROLE_ADMIN",
                "Utilisateur" => "ROLE_USER",
            ]])
            ->add('passwordConfirmation', PasswordType::class, ["attr" => ["class" => "forminput"]])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->add("campus", EntityType::class, ["attr" => ["class" => "forminput"], "class" => "App\Entity\Campus", "choice_label" => "name"]);
>>>>>>> c62bbe19959762d5f86aa16b12b96e4470fc3795

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
