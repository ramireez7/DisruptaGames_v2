<?php

namespace App\Controller;

use App\BLL\JuegoBLL;
use App\Entity\Juego;
use App\Form\JuegoType;
use App\Repository\JuegoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/games')]
class JuegoController extends AbstractController
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    #[Route('/', name: 'app_games', methods: ['GET'])]
    #[Route('/orden/{ordenacion}', name: 'app_games_ordenado', methods: ['GET'])]
    public function index(JuegoBLL $juegoBLL, string $ordenacion=null): Response
    {
        $juegos = $juegoBLL->getJuegosConOrdenacion($ordenacion);
        $juegosConMasDescargas = $juegoBLL->getJuegosConMasDescargas();
        $juegosConMejorValoracion = $juegoBLL->getJuegosConMejorValoracion();
        
        return $this->render('juego/index.html.twig', [
            'juegosConMasDescargas' => $juegosConMasDescargas,
            'juegosConMejorValoracion' => $juegosConMejorValoracion,
            'juegos' => $juegos]);
    }

    #[Route('/new', name: 'app_games_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $juego = new Juego();
        $form = $this->createForm(JuegoType::class, $juego);
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
                        $this->params->get('images_directory_juegos'),
                        $nombreArchivo
                    );
                } catch (FileException $e) {
                    // Manejar errores si la carga de la imagen falla
                }

                // Establecer el nombre de la imagen en el juego
                $juego->setImagen($nombreArchivo);
            }

            $juego->setNumDownloads(0);

            $entityManager->persist($juego);
            $entityManager->flush();

            return $this->redirectToRoute('app_games', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('juego/new.html.twig', [
            'juego' => $juego,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_games_show', methods: ['GET'])]
    public function show(Juego $juego): Response
    {
        return $this->render('juego/show.html.twig', [
            'juego' => $juego,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_games_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Juego $juego, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JuegoType::class, $juego);
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
                        $this->params->get('images_directory_juegos'),
                        $nombreArchivo
                    );
                } catch (FileException $e) {
                    // Manejar errores si la carga de la imagen falla
                }

                // Establecer el nombre de la imagen en el juego
                $juego->setImagen($nombreArchivo);
            }
            
            $entityManager->flush();

            return $this->redirectToRoute('app_games', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('juego/edit.html.twig', [
            'juego' => $juego,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_games_delete', methods: ['POST'])]
    public function delete(Request $request, Juego $juego, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $juego->getId(), $request->request->get('_token'))) {
            $entityManager->remove($juego);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_games', [], Response::HTTP_SEE_OTHER);
    }
}
