<?php

namespace App\Controller;

use App\Entity\Juego;
use App\Form\JuegoType;
use App\Repository\JuegoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/games')]
class JuegoController extends AbstractController
{
    #[Route('/', name: 'app_games', methods: ['GET'])]
    public function index(JuegoRepository $juegoRepository): Response
    {
        $juegosPopulares = ['hola', 'adios'];
        $juegosMasDescargados = ['hola', 'adios'];
        $juegos = ['hola', 'adios'];
        return $this->render('juego/index.html.twig', [
            'juegosPopulares' => $juegosPopulares,
            'juegosMasDescargados' => $juegosMasDescargados,
            'juegos' => $juegos]);
    }

    #[Route('/new', name: 'app_games_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $juego = new Juego();
        $form = $this->createForm(JuegoType::class, $juego);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

    #[Route('/{id}/edit', name: 'app_games_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Juego $juego, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JuegoType::class, $juego);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
