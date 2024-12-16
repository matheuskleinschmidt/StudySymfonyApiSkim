<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\State;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cities')]
class CityController extends AbstractController
{
    #[Route('', name: 'cities_list', methods: ['GET'])]
    public function listCities(ManagerRegistry $doctrine): JsonResponse
    {
        $cities = $doctrine->getRepository(City::class)->findAll();
        return $this->json($cities, 200, []);
    }

    #[Route('/{id}', name: 'cities_show', methods: ['GET'])]
    public function showCity(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $city = $doctrine->getRepository(City::class)->find($id);

        if (!$city) {
            return $this->json(['error' => 'City not found'], 404);
        }

        return $this->json($city, 200, []);
    }

    #[Route('', name: 'cities_create', methods: ['POST'])]
    public function createCity(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['name']) || !isset($data['state_id'])) {
            return $this->json(['error' => 'Invalid input data. "name" and "state_id" are required.'], 400);
        }

        $state = $entityManager->getRepository(State::class)->find($data['state_id']);
        if (!$state) {
            return $this->json(['error' => 'State not found'], 404);
        }

        $city = new City();
        $city->setName($data['name']);
        $city->setState($state);

        $entityManager->persist($city);
        $entityManager->flush();

        return $this->json($city, 201);
    }

    #[Route('/{id}', name: 'cities_update', methods: ['PUT'])]
    public function updateCity(Request $request, ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $city = $entityManager->getRepository(City::class)->find($id);

        if (!$city) {
            return $this->json(['error' => 'City not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return $this->json(['error' => 'Invalid input data.'], 400);
        }

        if (isset($data['name'])) {
            $city->setName($data['name']);
        }

        if (isset($data['state_id'])) {
            $state = $entityManager->getRepository(State::class)->find($data['state_id']);
            if (!$state) {
                return $this->json(['error' => 'State not found'], 404);
            }
            $city->setState($state);
        }

        $entityManager->flush();

        return $this->json($city, 200);
    }

    #[Route('/{id}', name: 'cities_delete', methods: ['DELETE'])]
    public function deleteCity(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $city = $entityManager->getRepository(City::class)->find($id);

        if (!$city) {
            return $this->json(['error' => 'City not found'], 404);
        }

        $entityManager->remove($city);
        $entityManager->flush();

        return new JsonResponse(null, 204);
    }
}
