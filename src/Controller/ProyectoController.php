<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProyectoController extends AbstractController
{
  #[Route('/', name: 'dis_index')]
  public function index()
  {
    return $this->render('index.html.twig');
  }

  #[Route('/browse', name: 'dis_browse')]
  public function browse()
  {
    $juegos = ['hola', 'adios'];
    $juegosMasDescargados = ['hola', 'adios'];
    $juegos = ['hola', 'adios'];
    $postsDestacados = ['hola', 'adios'];
    return $this->render('browse.html.twig', ['juegos' => $juegos, 'juegosMasDescargados' => $juegosMasDescargados, 'postsDestacados' => $postsDestacados]);
  }

  #[Route('/games', name: 'dis_games')]
  public function games()
  {
    $juegosPopulares = ['hola', 'adios'];
    $juegosMasDescargados = ['hola', 'adios'];
    $juegos = ['hola', 'adios'];
    return $this->render('games.html.twig', ['juegosPopulares' => $juegosPopulares, 'juegosMasDescargados' => $juegosMasDescargados, 'juegos' => $juegos]);
  }

  #[Route('/posts', name: 'dis_posts')]
  public function posts()
  {
    $postsDestacados = ['hola', 'adios'];
    $posts = ['hola', 'adios'];
    return $this->render('posts.html.twig', ['postsDestacados' => $postsDestacados,  'posts' => $posts]);
  }

  #[Route('/login', name: 'dis_login')]
  public function login()
  {
    return $this->render('login.html.twig');
  }

  #[Route('/register', name: 'dis_register')]
  public function register()
  {
    return $this->render('register.html.twig');
  }

  #[Route('/profile', name: 'dis_profile')]
  public function profile()
  {
    $posts = ['hola', 'adios'];
    return $this->render('profile.html.twig', ['posts' => $posts]);
  }
}