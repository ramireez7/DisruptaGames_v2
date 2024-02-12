<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, ['label' => 'Nombre de usuario', 'label_attr' => ['class' => 'text-white'], 'attr' => ['class' => 'bg-dark text-white']])
            ->add('email', EmailType::class, ['label' => 'Correo electrónico', 'label_attr' => ['class' => 'text-white'], 'attr' => ['class' => 'bg-dark text-white']])
            ->add('profileImage', FileType::class, [
                'label' => 'Imagen de perfil',
                'label_attr' => ['class' => 'text-white'],
                'attr' => ['class' => 'bg-dark text-white'],
                'data_class' => null,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Por favor, seleccione un archivo jpg o png'
                    ])
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'class' => 'bg-dark text-white'],
                'label' => 'Contraseña',
                'label_attr' => ['class' => 'text-white'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, indica una contraseña',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'La contraseña debe tener al menos {{ limit }} caracteres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
