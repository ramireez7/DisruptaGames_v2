<?php

namespace App\Form;

use App\Entity\Juego;
use App\Entity\Post;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('descripcion')
            ->add('imagen')
            ->add('fecha')
            ->add('numLikes')
            ->add('idCreador', EntityType::class, [
                'class' => Usuario::class,
'choice_label' => 'id',
            ])
            ->add('idJuego', EntityType::class, [
                'class' => Juego::class,
'choice_label' => 'id',
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
