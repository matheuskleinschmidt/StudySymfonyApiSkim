<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Continent;
use App\Entity\Country;
use App\Entity\Facility;
use App\Entity\State;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FilterDataController extends AbstractController
{
    /**
     * Retorna todos os registros de City, Country, Facility, State e Continent.
     */
    #[Route('/filter-data', name: 'filter_data', methods: ['GET'])]
    public function getFilterData(ManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $continents = $entityManager->getRepository(Continent::class)->findAll();
        $countries  = $entityManager->getRepository(Country::class)->findAll();
        $states     = $entityManager->getRepository(State::class)->findAll();
        $cities     = $entityManager->getRepository(City::class)->findAll();
        $facilities = $entityManager->getRepository(Facility::class)->findAll();

        return $this->json([
            'continents' => $continents,
            'countries'  => $countries,
            'states'     => $states,
            'cities'     => $cities,
            'facilities' => $facilities,
        ], 200);
    }
}
