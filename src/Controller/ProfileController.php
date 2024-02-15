<?php

namespace App\Controller;

use App\BLL\PostBLL;
use App\Entity\Usuario;
use App\Form\PasswordFormType;
use App\Form\ProfileImageFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile')]
class ProfileController extends AbstractController
{
  private $params;

  public function __construct(ParameterBagInterface $params)
  {
    $this->params = $params;
  }

  #[Route('/', name: 'app_profile', methods: ['GET'])]
  public function index(PostBLL $postBLL, string $ordenacion = null): Response
  {
    $posts = $postBLL->getPostsDelUsuarioLogueado($ordenacion);
    return $this->render('profile/index.html.twig', [
      'posts' => $posts
    ]);
  }

  #[Route('/change-password/{id}', name: 'app_change_password', methods: ['GET', 'POST'])]
  public function changePassword(Request $request, UserPasswordHasherInterface $userPasswordHasher, Usuario $usuario, EntityManagerInterface $entityManager): Response
  {
    $form = $this->createForm(PasswordFormType::class, $usuario);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      // encode the plain password
      $usuario->setPassword(
        $userPasswordHasher->hashPassword(
          $usuario,
          $form->get('plainPassword')->getData()
        )
      );

      $entityManager->persist($usuario);
      $entityManager->flush();
      return $this->redirectToRoute('app_profile');
    }

    return $this->render('profile/change_password_form.html.twig', [
      'usuario' => $usuario,
      'form' => $form,
    ]);
  }


  #[Route('/change-profile-image/{id}', name: 'app_change_profile_image', methods: ['GET', 'POST'])]
  public function changeProfileImage(Request $request, Usuario $usuario, EntityManagerInterface $entityManager): Response
  {
    $form = $this->createForm(ProfileImageFormType::class, $usuario);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
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

      $entityManager->persist($usuario);
      $entityManager->flush();
      return $this->redirectToRoute('app_profile');
    }

    return $this->render('profile/change_profile_image_form.html.twig', [
      'usuario' => $usuario,
      'form' => $form,
    ]);
  }
}
