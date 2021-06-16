<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnoncesController extends AbstractController
{
    /**
     * @Route("/", name="annonces")
     * @param AnnonceRepository $repo
     * @return Response
     */
    public function index(AnnonceRepository $repo): Response
    {
        $articles = $repo->findAll();

        return $this->render('annonces/annonces.html.twig', [
            'controller_name' => 'AnnoncesController',
            'annonces' => $articles
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param Annonce $annonce
     * @return Response
     */
    public function showPost(Annonce $annonce): Response
    {
        return $this->render('annonces/show.html.twig', [
            'annonce' => $annonce
        ]);
    }
}
