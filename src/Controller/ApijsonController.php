<?php

namespace App\Controller;

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
        return $this->json([
            'message'=>'Welcome to json api',
            'path'=> 'ici'
        ]);

    }
}
