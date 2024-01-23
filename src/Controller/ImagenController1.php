<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Imagen;

class ImagenController1 extends AbstractController
{
    #[Route('/imagen', name: 'app_imagen')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $imagenes = $doctrine->getRepository(Imagen::class)->findAll();
        //Lo que sería galeria
        return $this->render('imagen/index.html.twig', [
            'imagenes' => $imagenes
        ]);
    }

    //Para ir a los detalles de la imagen, si queremos buscar por descipción, se cambia el id por descripción
    #[Route('/imagen/{id}', name: 'sym_imagen_show')]
    public function show(Imagen $imagen): Response
    {
        return $this->render('imagen/show.html.twig', [
            'imagen' => $imagen
        ]);
    }
}
