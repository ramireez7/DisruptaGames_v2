<?php

namespace App\Controller;

use App\Entity\Imagen;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProyectoController extends AbstractController
{
    #[Route('/', name: 'sym_index')]
    public function index()
    {
        $imagenesHome[] = new Imagen('1.jpg', 'descripción imagen 1', 1, 456, 610, 130);
        $imagenesHome[] = new Imagen('2.jpg', 'descripción imagen 2', 1, 456, 610, 130);
        $imagenesHome[] = new Imagen('3.jpg', 'descripción imagen 3', 2, 25, 80, 190);
        $imagenesHome[] = new Imagen('4.jpg', 'descripción imagen 4', 1, 456, 610, 130);
        $imagenesHome[] = new Imagen('5.jpg', 'descripción imagen 5', 3, 456, 610, 130);
        $imagenesHome[] = new Imagen('6.jpg', 'descripción imagen 6', 2, 456, 610, 130);
        $imagenesHome[] = new Imagen('7.jpg', 'descripción imagen 7', 1, 456, 610, 130);
        $imagenesHome[] = new Imagen('8.jpg', 'descripción imagen 8', 1, 456, 610, 130);
        $imagenesHome[] = new Imagen('9.jpg', 'descripción imagen 9', 1, 456, 610, 130);
        $imagenesHome[] = new Imagen('10.jpg', 'descripción imagen 10', 1, 456, 610, 130);
        $imagenesHome[] = new Imagen('11.jpg', 'descripción imagen 11', 2, 456, 610, 130);
        $imagenesHome[] = new Imagen('12.jpg', 'descripción imagen 12', 1, 456, 610, 130);

        return $this->render('index.html.twig', ['imagenes' => $imagenesHome]);
    }

    #[Route('/login', name: 'sym_login')]
    public function login()
    {
        return $this->render('base.html.twig');
    }

    #[Route('/register', name: 'app_register')]
    public function registro()
    {
        return $this->render('base.html.twig');
    }

    #[Route('/galeria', name: 'sym_galeria')]
    public function galeria()
    {
        return $this->render('base.html.twig');
    }

    #[Route('/asociados', name: 'sym_asociados')]
    public function asociados()
    {
        return $this->render('base.html.twig');
    }

    #[Route('/logout', name: 'sym_logout')]
    public function logout()
    {
        return $this->render('base.html.twig');
    }

    #[Route('/about', name: 'sym_about')]
    public function about()
    {
        $imagenesClientes[] = new Imagen('client1.jpg', 'MISS BELLA');
        $imagenesClientes[] = new Imagen('client2.jpg', 'DON PENO');
        $imagenesClientes[] = new Imagen('client3.jpg', 'SWEETY');
        $imagenesClientes[] = new Imagen('client4.jpg', 'LADY');

        return $this->render('about.html.twig', ['imagenes' => $imagenesClientes]);
    }

    #[Route('/blog', name: 'sym_blog')]
    public function blog()
    {
        return $this->render('blog.html.twig');
    }

    #[Route('/contact', name: 'sym_contact')]
    public function contact()
    {
        return $this->render('contact.html.twig');
    }
}
