<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

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
            ->add('imageFile', FileType::class,
                [
                    'mapped' => false,
                    'required' => false,
                    'label'=> '(Format png/jpeg accepté)',
                    'constraints' => [
                        new Image
                        (
                            [
                                'maxSize' => '7040k',
                                'mimeTypes' =>
                                    [
                                        'image/png',
                                        'image/jpeg',
                                    ],
                                'mimeTypesMessage' => 'SVP téléchargez une photo valide',
                            ]
                        )
                    ]
                ]
            )
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
