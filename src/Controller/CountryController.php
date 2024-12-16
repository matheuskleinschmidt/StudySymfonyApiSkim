<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\Continent;
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
        return $this->json($countries, 200);
    }

    #[Route('/{id}', name: 'countries_show', methods: ['GET'])]
    public function showCountry(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $country = $doctrine->getRepository(Country::class)->find($id);

        if (!$country) {
            return $this->json(['error' => 'Country not found'], 404);
        }

        return $this->json($country, 200);
    }

    #[Route('', name: 'countries_create', methods: ['POST'])]
    public function createCountry(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data || !isset($data['name']) || !isset($data['continent_id'])) {
            return $this->json(['error' => 'Invalid input data. "name" and "continent_id" are required.'], 400);
        }

        $entityManager = $doctrine->getManager();
        $continent = $entityManager->getRepository(Continent::class)->find($data['continent_id']);
        if (!$continent) {
            return $this->json(['error' => 'Continent not found'], 404);
        }

        $country = new Country();
        $country->setName($data['name']);
        $country->setIsoCode($data['isoCode'] ?? null);
        $country->setContinent($continent);

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

        if (isset($data['continent_id'])) {
            $continent = $entityManager->getRepository(Continent::class)->find($data['continent_id']);
            if (!$continent) {
                return $this->json(['error' => 'Continent not found'], 404);
            }
            $country->setContinent($continent);
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
