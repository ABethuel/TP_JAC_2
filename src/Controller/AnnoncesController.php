<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/new", name="new")
     * @Route("/{id}/edit", name="edit_announce")
     * @param Annonce|null $annonce
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function new(Annonce $annonce = null, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$annonce) {
            $annonce = new Annonce();
        }

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$annonce->getId()) {
                $annonce->setDate(new \DateTime());
            }
            $manager->persist($annonce);
            $manager->flush();

            return $this->redirectToRoute('show', ['id' => $annonce->getId()]);
        }

        return $this->render('annonces/new.html.twig', [
            'formAnnonce' => $form->createView(),
            'editMode' => $annonce ->getId() !== null,
            'annonce' => $annonce
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param Annonce $annonce
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function show(Annonce $annonce, EntityManagerInterface $manager): Response
    {

        return $this->render('annonces/show.html.twig', [
            'annonce' => $annonce
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Annonce $annonce
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Annonce $annonce, EntityManagerInterface $manager): Response
    {

        $manager->remove($annonce);
        $manager->flush();

        return $this->redirectToRoute("annonces", [
            'annonce'=> $annonce
        ]);
    }
}
