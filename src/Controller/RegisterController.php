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

class RegisterController extends AbstractController
{
  private $params;

  public function __construct(ParameterBagInterface $params)
  {
    $this->params = $params;
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
}
