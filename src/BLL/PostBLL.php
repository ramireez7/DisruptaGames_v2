<?php

namespace App\BLL;

use App\Repository\PostRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class PostBLL
{
  private Security $security;
  private RequestStack $requestStack;
  private PostRepository $postRepository;
  public function __construct(Security $security, RequestStack $requestStack, PostRepository $postRepository)
  {
    $this->security = $security;
    $this->requestStack = $requestStack;
    $this->postRepository = $postRepository;
  }
  public function getPostsConCreadorYJuego(?string $ordenacion)
  {
    if (!is_null($ordenacion)) { // Cuando se establece un tipo de ordenación específico
      $tipoOrdenacion = 'asc'; // Por defecto si no se había guardado antes en la variable de sesión
      $session = $this->requestStack->getSession(); // Abrir la sesión
      $postsOrdenacion = $session->get('postsOrdenacion');
      if (!is_null($postsOrdenacion)) { // Comprobamos si ya se había establecido un orden
        if ($postsOrdenacion['ordenacion'] === $ordenacion) // Por si se ha cambiado de campo a ordenar
        {
          if ($postsOrdenacion['tipoOrdenacion'] === 'asc')
            $tipoOrdenacion = 'desc';
        }
      }
      $session->set('postsOrdenacion', [ // Se guarda la ordenación actual
        'ordenacion' => $ordenacion,
        'tipoOrdenacion' => $tipoOrdenacion
      ]);
    } else { // La primera vez que se entra se establece por defecto la ordenación por id ascendente
      $ordenacion = 'id';
      $tipoOrdenacion = 'asc';
    }
    return $this->postRepository->findPostsConCreadorYJuego($ordenacion, $tipoOrdenacion);
  }

  public function getPostsDelUsuarioLogueado(?string $ordenacion)
  {
    $userId = $this->security->getUser()->getId();
    if (!is_null($ordenacion)) { // Cuando se establece un tipo de ordenación específico
      $tipoOrdenacion = 'asc'; // Por defecto si no se había guardado antes en la variable de sesión
      $session = $this->requestStack->getSession(); // Abrir la sesión
      $postsOrdenacion = $session->get('postsOrdenacion');
      if (!is_null($postsOrdenacion)) { // Comprobamos si ya se había establecido un orden
        if ($postsOrdenacion['ordenacion'] === $ordenacion) // Por si se ha cambiado de campo a ordenar
        {
          if ($postsOrdenacion['tipoOrdenacion'] === 'asc')
            $tipoOrdenacion = 'desc';
        }
      }
      $session->set('postsOrdenacion', [ // Se guarda la ordenación actual
        'ordenacion' => $ordenacion,
        'tipoOrdenacion' => $tipoOrdenacion
      ]);
    } else { // La primera vez que se entra se establece por defecto la ordenación por id ascendente
      $ordenacion = 'id';
      $tipoOrdenacion = 'asc';
    }
    return $this->postRepository->findPostsDelUsuarioLogueado($ordenacion, $tipoOrdenacion, $userId);
  }

  public function getPostsConMasLikes()
  {
    return $this->postRepository->findPostsConMasLikes();
  }
}