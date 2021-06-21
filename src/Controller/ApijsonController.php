<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ApijsonController extends AbstractController
{
    /**
     * @Route("/json", name="/json", methods={"GET"})
     * @param AnnonceRepository $annonceRepository
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws ExceptionInterface
     */
    public function index(AnnonceRepository $annonceRepository, SerializerInterface $serializer): Response
    {
        $annonce = $annonceRepository->findAll();

       $json = $serializer->serialize($annonce, 'json');

        $response = new Response($json, 200, [
           "Content-Type" => "application/json"
        ]);

        return $response;
    }
}
