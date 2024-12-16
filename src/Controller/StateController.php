<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\State;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/states')]
class StateController extends AbstractController
{
    #[Route('', name: 'states_list', methods: ['GET'])]
    public function listStates(ManagerRegistry $doctrine): JsonResponse
    {
        $states = $doctrine->getRepository(State::class)->findAll();
        return $this->json($states, 200, []);
    }

    #[Route('/{id}', name: 'states_show', methods: ['GET'])]
    public function showState(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $state = $doctrine->getRepository(State::class)->find($id);

        if (!$state) {
            return $this->json(['error' => 'State not found'], 404);
        }

        return $this->json($state, 200, []);
    }

    #[Route('', name: 'states_create', methods: ['POST'])]
    public function createState(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['name']) || !isset($data['country_id'])) {
            return $this->json(['error' => 'Invalid input data. "name" and "country_id" are required.'], 400);
        }

        $country = $entityManager->getRepository(Country::class)->find($data['country_id']);
        if (!$country) {
            return $this->json(['error' => 'Country not found'], 404);
        }

        $state = new State();
        $state->setName($data['name']);
        $state->setCountry($country);

        $entityManager->persist($state);
        $entityManager->flush();

        return $this->json($state, 201);
    }

    #[Route('/{id}', name: 'states_update', methods: ['PUT'])]
    public function updateState(Request $request, ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $state = $entityManager->getRepository(State::class)->find($id);

        if (!$state) {
            return $this->json(['error' => 'State not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return $this->json(['error' => 'Invalid input data.'], 400);
        }

        if (isset($data['name'])) {
            $state->setName($data['name']);
        }

        if (isset($data['country_id'])) {
            $country = $entityManager->getRepository(Country::class)->find($data['country_id']);
            if (!$country) {
                return $this->json(['error' => 'Country not found'], 404);
            }
            $state->setCountry($country);
        }

        $entityManager->flush();

        return $this->json($state, 200);
    }

    #[Route('/{id}', name: 'states_delete', methods: ['DELETE'])]
    public function deleteState(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $state = $entityManager->getRepository(State::class)->find($id);

        if (!$state) {
            return $this->json(['error' => 'State not found'], 404);
        }

        $entityManager->remove($state);
        $entityManager->flush();

        return new JsonResponse(null, 204);
    }
}
