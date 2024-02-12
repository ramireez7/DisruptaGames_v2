<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrowseController extends AbstractController
{
    #[Route('/browse', name: 'app_browse')]
    public function index(): Response
    {
        $juegos = ['hola', 'adios'];
        $juegosMasDescargados = ['hola', 'adios'];
        $juegos = ['hola', 'adios'];
        $postsDestacados = ['hola', 'adios'];

        return $this->render('browse/index.html.twig', [
            'juegos' => $juegos,
            'juegosMasDescargados' => $juegosMasDescargados,
            'postsDestacados' => $postsDestacados
        ]);
    }
}
