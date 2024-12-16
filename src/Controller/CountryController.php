<?php

namespace App\Controller;

use App\Entity\Country;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/countries')]
class CountryController extends AbstractController
{
    #[Route('', name: 'countries_list', methods: ['GET'])]
    public function listCountries(ManagerRegistry $doctrine): JsonResponse
    {
        $countries = $doctrine->getRepository(Country::class)->findAll();
        return $this->json($countries, 200, []);
    }

    #[Route('/{id}', name: 'countries_show', methods: ['GET'])]
    public function showCountry(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $country = $doctrine->getRepository(Country::class)->find($id);

        if (!$country) {
            return $this->json(['error' => 'Country not found'], 404);
        }

        return $this->json($country, 200, []);
    }

    #[Route('', name: 'countries_create', methods: ['POST'])]
    public function createCountry(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['name'])) {
            return $this->json(['error' => 'Invalid input data. "name" is required.'], 400);
        }

        $country = new Country();
        $country->setName($data['name']);
        $country->setIsoCode($data['isoCode'] ?? null);
        // Caso exista um campo "continent" como string:
        $country->setContinent($data['continent'] ?? null);

        $entityManager->persist($country);
        $entityManager->flush();

        return $this->json($country, 201);
    }

    #[Route('/{id}', name: 'countries_update', methods: ['PUT'])]
    public function updateCountry(Request $request, ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $country = $entityManager->getRepository(Country::class)->find($id);

        if (!$country) {
            return $this->json(['error' => 'Country not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return $this->json(['error' => 'Invalid input data.'], 400);
        }

        if (isset($data['name'])) {
            $country->setName($data['name']);
        }
        if (array_key_exists('isoCode', $data)) {
            $country->setIsoCode($data['isoCode']);
        }
        if (array_key_exists('continent', $data)) {
            $country->setContinent($data['continent']);
        }

        $entityManager->flush();

        return $this->json($country, 200);
    }

    #[Route('/{id}', name: 'countries_delete', methods: ['DELETE'])]
    public function deleteCountry(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $country = $entityManager->getRepository(Country::class)->find($id);

        if (!$country) {
            return $this->json(['error' => 'Country not found'], 404);
        }

        $entityManager->remove($country);
        $entityManager->flush();

        return new JsonResponse(null, 204);
    }
}
