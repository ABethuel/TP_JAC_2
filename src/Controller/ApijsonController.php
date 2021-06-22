<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApijsonController extends AbstractController
{
    /**
     * @Route("/json", name="json", methods={"GET"})
     * @param AnnonceRepository $annonceRepository
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function index(AnnonceRepository $annonceRepository, SerializerInterface $serializer): Response
    {
        $annonce = $annonceRepository->findAll();
        $json = $serializer->serialize($annonce, 'json');

        return new JsonResponse($json, 200, [], true);
    }


    /**
     * @Route("/json/create", name="create", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager, ValidatorInterface $validator): JsonResponse
    {
        $jsonGet = $request->getContent();

        try {
            $annonce = $serializer->deserialize($jsonGet, Annonce::class, 'json');
            $annonce->setDate(new \DateTime());

            $errors =$validator->validate($annonce);

            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }

            $manager->persist($annonce);
            $manager->flush();

            return $this->json($annonce, 201, []);

        } catch (NotEncodableValueException $e){
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }


    }
}
