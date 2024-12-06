<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MeuController extends AbstractController
{
    #[Route('/minha-rota', name: 'my_route_name')]
    public function minhaAcao(): JsonResponse
    {
        $data = [

                [
                    "id"=> 1,
                    "name"=> "adsfadf",
                    "adress"=> "1afadsfd",
                    "description"=> "adsfadf",
                    "observation"=> "adsfadsf",
                    "images"=> null,
                    "geoCoordinates"=> null
                ]               
        ];

        return new JsonResponse($data);
    }
}
