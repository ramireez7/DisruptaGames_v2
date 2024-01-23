<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AsociadosController extends AbstractController
{
    #[Route('/asociados', name: 'app_asociados')]
    public function index(): Response
    {
        return $this->render('asociados/index.html.twig', [
            'controller_name' => 'AsociadosController',
        ]);
    }
}
