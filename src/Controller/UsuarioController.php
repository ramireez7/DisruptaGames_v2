<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users')]
class UsuarioController extends AbstractController
{
  private $params;

  public function __construct(ParameterBagInterface $params)
  {
    $this->params = $params;
  }

  #[Route('/', name: 'app_usuarios', methods: ['GET'])]
  public function index(UsuarioRepository $usuarioRepository): Response
  {
    return $this->render('usuario/index.html.twig', [
      'usuarios' => $usuarioRepository->findAll(),
    ]);
  }

  #[Route('/{id}', name: 'app_usuarios_show', methods: ['GET'])]
  public function show(Usuario $usuario): Response
  {
    return $this->render('usuario/show.html.twig', [
      'usuario' => $usuario,
    ]);
  }

  #[Route('/edit/{id}', name: 'app_usuarios_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, UserPasswordHasherInterface $userPasswordHasher, Usuario $usuario, EntityManagerInterface $entityManager): Response
  {
    $form = $this->createForm(UsuarioType::class, $usuario);
    $form->get('profileImage')->setData($usuario->getProfileImage());
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
        $nombreArchivo = md5(uniqid()) . '.' . $imagenPerfil->guessExtension();

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

    return $this->render('usuario/edit.html.twig', [
      'usuario' => $usuario,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_usuarios_delete', methods: ['POST'])]
  public function delete(Request $request, Usuario $usuario, EntityManagerInterface $entityManager): Response
  {
    if ($this->isCsrfTokenValid('delete' . $usuario->getId(), $request->request->get('_token'))) {
      $entityManager->remove($usuario);
      $entityManager->flush();
    }

    return $this->redirectToRoute('app_usuarios', [], Response::HTTP_SEE_OTHER);
  }
}
