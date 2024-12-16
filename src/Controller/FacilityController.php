<?php

namespace App\Controller;

use App\Entity\Facility;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/facilities')]
class FacilityController extends AbstractController
{
    #[Route('', name: 'facilities_list', methods: ['GET'])]
    public function listFacilities(ManagerRegistry $doctrine): JsonResponse
    {
        $facilities = $doctrine->getRepository(Facility::class)->findAll();
        return $this->json($facilities, 200, []);
    }

    #[Route('/{id}', name: 'facilities_show', methods: ['GET'])]
    public function showFacility(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $facility = $doctrine->getRepository(Facility::class)->find($id);

        if (!$facility) {
            return $this->json(['error' => 'Facility not found'], 404);
        }

        return $this->json($facility, 200, []);
    }

    #[Route('', name: 'facilities_create', methods: ['POST'])]
    public function createFacility(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['name'])) {
            return $this->json(['error' => 'Invalid input data. "name" is required.'], 400);
        }

        $facility = new Facility();
        $facility->setName($data['name']);

        $entityManager->persist($facility);
        $entityManager->flush();

        return $this->json($facility, 201);
    }

    #[Route('/{id}', name: 'facilities_update', methods: ['PUT'])]
    public function updateFacility(Request $request, ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $facility = $entityManager->getRepository(Facility::class)->find($id);

        if (!$facility) {
            return $this->json(['error' => 'Facility not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return $this->json(['error' => 'Invalid input data.'], 400);
        }

        if (isset($data['name'])) {
            $facility->setName($data['name']);
        }

        $entityManager->flush();

        return $this->json($facility, 200);
    }

    #[Route('/{id}', name: 'facilities_delete', methods: ['DELETE'])]
    public function deleteFacility(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $facility = $entityManager->getRepository(Facility::class)->find($id);

        if (!$facility) {
            return $this->json(['error' => 'Facility not found'], 404);
        }

        $entityManager->remove($facility);
        $entityManager->flush();

        return new JsonResponse(null, 204);
    }
}
