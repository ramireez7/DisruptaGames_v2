<?php
namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProyectoController extends AbstractController
{

  private $params;

  public function __construct(ParameterBagInterface $params)
  {
    $this->params = $params;
  }
  
  #[Route('/', name: 'app_index')]
  public function index()
  {
    return $this->render('index.html.twig');
  }

  #[Route('/browse', name: 'app_browse')]
  public function browse()
  {
    $juegos = ['hola', 'adios'];
    $juegosMasDescargados = ['hola', 'adios'];
    $juegos = ['hola', 'adios'];
    $postsDestacados = ['hola', 'adios'];
    return $this->render('browse.html.twig', ['juegos' => $juegos, 'juegosMasDescargados' => $juegosMasDescargados, 'postsDestacados' => $postsDestacados]);
  }

  #[Route('/games', name: 'app_games')]
  public function games()
  {
    $juegosPopulares = ['hola', 'adios'];
    $juegosMasDescargados = ['hola', 'adios'];
    $juegos = ['hola', 'adios'];
    return $this->render('games.html.twig', ['juegosPopulares' => $juegosPopulares, 'juegosMasDescargados' => $juegosMasDescargados, 'juegos' => $juegos]);
  }

  #[Route('/login', name: 'app_login')]
  public function login()
  {
    return $this->render('login.html.twig');
  }

  #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
  public function new(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
  {
    $usuario = new Usuario();
    $form = $this->createForm(UsuarioType::class, $usuario);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      // encode the plain password
      $usuario->setPassword(
        $userPasswordHasher->hashPassword(
          $usuario,
          $form->get('plainPassword')->getData()
        )
      );

      // Manejar la carga de la imagen
      $imagenPerfil = $form['profileImage']->getData();

      if ($imagenPerfil) {
        // Generar un nombre único para la imagen
        $nombreArchivo = uniqid() . '.' . $imagenPerfil->guessExtension();

        // Mover la imagen al directorio de destino
        try {
          $imagenPerfil->move(
            $this->params->get('images_directory_imagenesPerfil'),
            $nombreArchivo
          );
        } catch (FileException $e) {
          // Manejar errores si la carga de la imagen falla
        }

        // Establecer el nombre de la imagen en el usuario
        $usuario->setProfileImage($nombreArchivo);
      }

      $usuario->setRoles(["ROLE_USER"]);
      $usuario->setNumPosts(0);
      $entityManager->persist($usuario);
      $entityManager->flush();

      return $this->redirectToRoute('app_login');
    }

    return $this->render('usuario/new.html.twig', [
      'usuario' => $usuario,
      'form' => $form,
    ]);
  }

  #[Route('/profile', name: 'app_profile')]
  public function profile()
  {
    $posts = ['hola', 'adios'];
    return $this->render('profile.html.twig', ['posts' => $posts]);
  }
}