<?php

namespace App\Controller;

use App\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApijsonController extends AbstractController
{
    /**
     * @Route("/json", name="/json")
     */
    public function index(): Response
    {

        $repo = $this->getDoctrine()->getRepository(Annonce::class);
        $annonce = $repo->findAll();

        return $this->json([
            $annonce
        ]);

    }
}
