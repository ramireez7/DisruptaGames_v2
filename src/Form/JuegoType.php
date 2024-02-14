<?php

namespace App\Form;

use App\Entity\Categoria;
use App\Entity\Juego;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class JuegoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Name',
                'label_attr' => ['class' => 'text-white'],
                'attr' => ['class' => 'bg-dark text-white']
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Description',
                'label_attr' => ['class' => 'text-white'],
                'attr' => ['class' => 'bg-dark text-white']
            ])
            ->add('precio', NumberType::class, [
                'label' => 'Price',
                'label_attr' => ['class' => 'text-white'],
                'attr' => ['class' => 'bg-dark text-white'],
                'constraints' => [
                    new GreaterThanOrEqual(0),
                ]
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
                        'mimeTypesMessage' => 'Please, select a jpg or png file'
                    ])
                ]
            ])
            ->add('rating', NumberType::class, [
                'label' => 'Rating',
                'label_attr' => ['class' => 'text-white'],
                'attr' => ['class' => 'bg-dark text-white'],
                'constraints' => [
                    new GreaterThanOrEqual(0),
                    new LessThanOrEqual(5)
                ]
            ])
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'nombre',
                'label' => 'Category',
                'label_attr' => ['class' => 'text-white'],
                'attr' => ['class' => 'bg-dark text-white']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Juego::class,
        ]);
    }
}
