<?php

namespace App\Controller;

use App\Entity\Continent;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/continents')]
class ContinentController extends AbstractController
{
    #[Route('', name: 'continents_list', methods: ['GET'])]
    public function listContinents(ManagerRegistry $doctrine): JsonResponse
    {
        $continents = $doctrine->getRepository(Continent::class)->findAll();
        return $this->json($continents, 200);
    }

    #[Route('/{id}', name: 'continents_show', methods: ['GET'])]
    public function showContinent(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $continent = $doctrine->getRepository(Continent::class)->find($id);
        if (!$continent) {
            return $this->json(['error' => 'Continent not found'], 404);
        }

        return $this->json($continent, 200);
    }

    #[Route('', name: 'continents_create', methods: ['POST'])]
    public function createContinent(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data || !isset($data['name'])) {
            return $this->json(['error' => 'Invalid input data. "name" is required.'], 400);
        }

        $entityManager = $doctrine->getManager();

        $continent = new Continent();
        $continent->setName($data['name']);

        $entityManager->persist($continent);
        $entityManager->flush();

        return $this->json($continent, 201);
    }

    #[Route('/{id}', name: 'continents_update', methods: ['PUT'])]
    public function updateContinent(Request $request, ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $continent = $entityManager->getRepository(Continent::class)->find($id);
        if (!$continent) {
            return $this->json(['error' => 'Continent not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return $this->json(['error' => 'Invalid input data.'], 400);
        }

        if (isset($data['name'])) {
            $continent->setName($data['name']);
        }

        $entityManager->flush();

        return $this->json($continent, 200);
    }

    #[Route('/{id}', name: 'continents_delete', methods: ['DELETE'])]
    public function deleteContinent(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $continent = $entityManager->getRepository(Continent::class)->find($id);
        if (!$continent) {
            return $this->json(['error' => 'Continent not found'], 404);
        }

        $entityManager->remove($continent);
        $entityManager->flush();

        return new JsonResponse(null, 204);
    }
}
