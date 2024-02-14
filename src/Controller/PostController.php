<?php

namespace App\Controller;

use App\BLL\PostBLL;
use App\Entity\Post;
use App\Form\PostType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/posts')]
class PostController extends AbstractController
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    #[Route('/', name: 'app_posts', methods: ['GET'])]
    #[Route('/orden/{ordenacion}', name: 'app_posts_ordenado', methods: ['GET'])]
    public function index(PostBLL $postBLL, string $ordenacion=null): Response
    {
        $posts = $postBLL->getPostsConCreadorYJuego($ordenacion);
        $postsConMasLikes = $postBLL->getPostsConMasLikes();
        
        return $this->render('post/index.html.twig', [
            'postsConMasLikes' => $postsConMasLikes,
            'posts' => $posts]);
    }

    #[Route('/new', name: 'app_posts_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Manejar la carga de la imagen
            $imagen = $form['imagen']->getData();

            if ($imagen) {
                // Generar un nombre único para la imagen
                $nombreArchivo = md5(uniqid()) . '.' . $imagen->guessExtension();

                // Mover la imagen al directorio de destino
                try {
                    $imagen->move(
                        $this->params->get('images_directory_posts'),
                        $nombreArchivo
                    );
                } catch (FileException $e) {
                    // Manejar errores si la carga de la imagen falla
                }

                // Establecer el nombre de la imagen en el post
                $post->setImagen($nombreArchivo);
            }

            $usuario = $this->getUser();
            $post->setIdCreador($usuario);
            $post->setNumLikes(0);
            $fecha = new DateTime();
            $post->setFecha($fecha);

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_posts', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_posts_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_posts_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_posts', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_posts_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_posts', [], Response::HTTP_SEE_OTHER);
    }
}
