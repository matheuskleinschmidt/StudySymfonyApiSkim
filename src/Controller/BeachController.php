<?php

namespace App\Controller;

use App\Entity\Beach;
use App\Entity\City;
use App\Entity\Photo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BeachController extends AbstractController
{
    #[Route('/beaches', name: 'beaches_list', methods: ['GET'])]
    public function listBeaches(ManagerRegistry $doctrine): JsonResponse
    {
        $repository = $doctrine->getRepository(Beach::class);
        $beaches = $repository->findAll();

        return $this->json($beaches, 200, [], ['groups' => ['beach']]);
    }

    #[Route('/beaches/{id}', name: 'beaches_show', methods: ['GET'])]
    public function showBeach(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $repository = $doctrine->getRepository(Beach::class);
        $beach = $repository->find($id);

        if (!$beach) {
            return $this->json(['error' => 'Beach not found'], 404);
        }

        return $this->json($beach, 200, [], ['groups' => ['beach']]);
    }

    #[Route('/beaches', name: 'beaches_create', methods: ['POST'])]
    public function createBeach(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['name'])) {
            return $this->json(['error' => 'Invalid input data. "name" is required.'], 400);
        }

        if (isset($data['city_id'])) {
            $city = $entityManager->getRepository(City::class)->find($data['city_id']);
            if (!$city) {
                return $this->json(['error' => 'City not found.'], 404);
            }
        } else {
            $city = null;
        }

        $beach = new Beach();
        $beach->setName($data['name']);
        $beach->setAddress($data['address'] ?? null);
        $beach->setGeoCoordinates($data['geoCoordinates'] ?? null);
        $beach->setDescription($data['description'] ?? null);
        $beach->setObservation($data['observation'] ?? null);
        $beach->setStatus($data['status'] ?? null);
        $beach->setPostalCode($data['postalCode'] ?? null);
        $beach->setCreatedAt(new \DateTime());
        $beach->setUpdatedAt(new \DateTime());

        if ($city) {
            $beach->setCity($city);
        }

        $entityManager->persist($beach);
        $entityManager->flush();

        return $this->json($beach, 201, [], ['groups' => ['beach']]);
    }

    #[Route('/beaches/{id}', name: 'beaches_update', methods: ['PUT'])]
    public function updateBeach(Request $request, ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(Beach::class);
        $beach = $repository->find($id);

        if (!$beach) {
            return $this->json(['error' => 'Beach not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'Invalid input data.'], 400);
        }

        if (isset($data['name'])) {
            $beach->setName($data['name']);
        }

        if (array_key_exists('address', $data)) {
            $beach->setAddress($data['address']);
        }

        if (array_key_exists('geoCoordinates', $data)) {
            $beach->setGeoCoordinates($data['geoCoordinates']);
        }

        if (array_key_exists('description', $data)) {
            $beach->setDescription($data['description']);
        }

        if (array_key_exists('observation', $data)) {
            $beach->setObservation($data['observation']);
        }

        if (array_key_exists('status', $data)) {
            $beach->setStatus($data['status']);
        }

        if (array_key_exists('postalCode', $data)) {
            $beach->setPostalCode($data['postalCode']);
        }

        if (isset($data['city_id'])) {
            $city = $entityManager->getRepository(City::class)->find($data['city_id']);
            if (!$city) {
                return $this->json(['error' => 'City not found.'], 404);
            }
            $beach->setCity($city);
        }

        $beach->setUpdatedAt(new \DateTime());

        $entityManager->flush();

        return $this->json($beach, 200, [], ['groups' => ['beach']]);
    }

    #[Route('/beaches/{id}', name: 'beaches_delete', methods: ['DELETE'])]
    public function deleteBeach(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(Beach::class);
        $beach = $repository->find($id);

        if (!$beach) {
            return $this->json(['error' => 'Beach not found'], 404);
        }

        $entityManager->remove($beach);
        $entityManager->flush();

        return new JsonResponse(null, 204);
    }

    #[Route('/beaches/{id}/photos', name: 'beaches_add_photo', methods: ['POST'])]
    public function addPhotoToBeach(Request $request, ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $beach = $entityManager->getRepository(Beach::class)->find($id);

        if (!$beach) {
            return $this->json(['error' => 'Beach not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['url']) || !isset($data['storageType'])) {
            return $this->json(['error' => 'Invalid input data. "url" and "storageType" are required.'], 400);
        }

        $photo = new Photo();
        $photo->setBeach($beach);
        $photo->setUrl($data['url']);
        $photo->setStorageType($data['storageType']);
        $photo->setCreatedAt(new \DateTime());

        if (isset($data['base64Data'])) {
            $photo->setBase64Data($data['base64Data']);
        }

        $entityManager->persist($photo);
        $entityManager->flush();

        return $this->json($photo, 201, [], ['groups' => ['beach']]);
    }
}
