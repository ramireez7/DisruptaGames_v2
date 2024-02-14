<?php

namespace App\Form;

use App\Entity\Juego;
use App\Entity\Post;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class, [
                'label' => 'Title',
                'label_attr' => ['class' => 'text-white'],
                'attr' => ['class' => 'bg-dark text-white']
            ])
            ->add('descripcion', TextType::class, [
                'label' => 'Description',
                'label_attr' => ['class' => 'text-white'],
                'attr' => ['class' => 'bg-dark text-white']
            ])
            ->add('imagen', FileType::class, [
                'label' => 'Image',
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
            ->add('idJuego', EntityType::class, [
                'class' => Juego::class,
                'choice_label' => 'nombre',
                'label' => 'Game',
                'label_attr' => ['class' => 'text-white'],
                'attr' => ['class' => 'bg-dark text-white'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
