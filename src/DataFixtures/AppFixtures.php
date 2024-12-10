<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\State;
use App\Entity\City;
use App\Entity\Facility;
use App\Enum\ContinentEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // 1. Populando Countries
        $countriesData = [
            // África
            [
                'name' => 'Nigéria',
                'iso_code' => 'NG',
                'continent' => ContinentEnum::AFRICA,
                'states' => [
                    ['name' => 'Lagos'],
                    ['name' => 'Kano'],
                ],
            ],
            [
                'name' => 'África do Sul',
                'iso_code' => 'ZA',
                'continent' => ContinentEnum::AFRICA,
                'states' => [
                    ['name' => 'Gauteng'],
                    ['name' => 'Western Cape'],
                ],
            ],
            // Ásia
            [
                'name' => 'Japão',
                'iso_code' => 'JP',
                'continent' => ContinentEnum::ASIA,
                'states' => [
                    ['name' => 'Tokyo'],
                    ['name' => 'Osaka'],
                ],
            ],
            [
                'name' => 'Índia',
                'iso_code' => 'IN',
                'continent' => ContinentEnum::ASIA,
                'states' => [
                    ['name' => 'Maharashtra'],
                    ['name' => 'Karnataka'],
                ],
            ],
            // Europa
            [
                'name' => 'Alemanha',
                'iso_code' => 'DE',
                'continent' => ContinentEnum::EUROPE,
                'states' => [
                    ['name' => 'Bavaria'],
                    ['name' => 'Berlin'],
                ],
            ],
            [
                'name' => 'França',
                'iso_code' => 'FR',
                'continent' => ContinentEnum::EUROPE,
                'states' => [
                    ['name' => 'Île-de-France'],
                    ['name' => 'Provence-Alpes-Côte d\'Azur'],
                ],
            ],
            // América do Norte
            [
                'name' => 'Estados Unidos',
                'iso_code' => 'US',
                'continent' => ContinentEnum::NORTH_AMERICA,
                'states' => [
                    ['name' => 'California'],
                    ['name' => 'Texas'],
                ],
            ],
            [
                'name' => 'Canadá',
                'iso_code' => 'CA',
                'continent' => ContinentEnum::NORTH_AMERICA,
                'states' => [
                    ['name' => 'Ontario'],
                    ['name' => 'Quebec'],
                ],
            ],
            // América do Sul
            [
                'name' => 'Brasil',
                'iso_code' => 'BR',
                'continent' => ContinentEnum::SOUTH_AMERICA,
                'states' => [
                    ['name' => 'São Paulo'],
                    ['name' => 'Rio de Janeiro'],
                ],
            ],
            [
                'name' => 'Argentina',
                'iso_code' => 'AR',
                'continent' => ContinentEnum::SOUTH_AMERICA,
                'states' => [
                    ['name' => 'Buenos Aires'],
                    ['name' => 'Cordoba'],
                ],
            ],
            // Austrália
            [
                'name' => 'Austrália',
                'iso_code' => 'AU',
                'continent' => ContinentEnum::AUSTRALIA,
                'states' => [
                    ['name' => 'New South Wales'],
                    ['name' => 'Victoria'],
                ],
            ],
            [
                'name' => 'Nova Zelândia',
                'iso_code' => 'NZ',
                'continent' => ContinentEnum::AUSTRALIA,
                'states' => [
                    ['name' => 'Auckland'],
                    ['name' => 'Wellington'],
                ],
            ],
            // Antártida - Geralmente sem países, mas para fins de seed, adicionaremos entradas fictícias
            [
                'name' => 'República de Antártida',
                'iso_code' => 'AQ1',
                'continent' => ContinentEnum::ANTARCTICA,
                'states' => [
                    ['name' => 'Região Oeste'],
                    ['name' => 'Região Leste'],
                ],
            ],
            [
                'name' => 'Território Antártico Austral',
                'iso_code' => 'AQ2',
                'continent' => ContinentEnum::ANTARCTICA,
                'states' => [
                    ['name' => 'Base McMurdo'],
                    ['name' => 'Base Amundsen-Scott'],
                ],
            ],
        ];

        $countryEntities = [];

        foreach ($countriesData as $countryData) {
            $country = new Country();
            $country->setName($countryData['name']);
            $country->setIsoCode($countryData['iso_code']);
            $country->setContinent($countryData['continent']);

            $manager->persist($country);
            $countryEntities[$countryData['name']] = $country;

            // Populando States e Cities para cada Country
            foreach ($countryData['states'] as $stateData) {
                $state = new State();
                $state->setName($stateData['name']);
                $state->setCountry($country);
                $manager->persist($state);

                // Populando algumas Cities para cada State
                $cities = $this->getSampleCities($countryData['name'], $stateData['name']);
                foreach ($cities as $cityName) {
                    $city = new City();
                    $city->setName($cityName);
                    $city->setState($state);
                    $manager->persist($city);
                }
            }
        }

        // 2. Populando Facilities
        $facilitiesData = [
            'Banheiros',
            'Estacionamento',
            'Salas de Primeiros Socorros',
            'Bar',
            'Quiosques de Alimentos',
            'Locais para Pernoite',
            'Espaços para Esportes Aquáticos',
            'Pistas de Caminhada',
            'Iluminação Noturna',
            'Wi-Fi Gratuito',
            'Vestiários',
            'Acessibilidade para Deficientes',
            'Lojas de Conveniência',
            'Área para Acampamento',
            'Espaço para Eventos',
        ];

        foreach ($facilitiesData as $facilityName) {
            $facility = new Facility();
            $facility->setName($facilityName);
            $manager->persist($facility);
        }

        // 3. Finalizando a Persistência
        $manager->flush();
    }

    /**
     * Retorna uma lista de nomes de cidades com base no país e estado fornecidos.
     *
     * @param string $country
     * @param string $state
     * @return array
     */
    private function getSampleCities(string $country, string $state): array
    {
        $cities = [];

        switch ($country) {
            case 'Nigéria':
                switch ($state) {
                    case 'Lagos':
                        $cities = ['Ikeja', 'Victoria Island', 'Lekki'];
                        break;
                    case 'Kano':
                        $cities = ['Kano City', 'Fagge', 'Gwale'];
                        break;
                }
                break;

            case 'África do Sul':
                switch ($state) {
                    case 'Gauteng':
                        $cities = ['Johannesburg', 'Pretoria', 'Soweto'];
                        break;
                    case 'Western Cape':
                        $cities = ['Cape Town', 'Stellenbosch', 'Paarl'];
                        break;
                }
                break;

            case 'Japão':
                switch ($state) {
                    case 'Tokyo':
                        $cities = ['Shinjuku', 'Shibuya', 'Akihabara'];
                        break;
                    case 'Osaka':
                        $cities = ['Namba', 'Umeda', 'Tennoji'];
                        break;
                }
                break;

            case 'Índia':
                switch ($state) {
                    case 'Maharashtra':
                        $cities = ['Mumbai', 'Pune', 'Nagpur'];
                        break;
                    case 'Karnataka':
                        $cities = ['Bangalore', 'Mysore', 'Hubli'];
                        break;
                }
                break;

            case 'Alemanha':
                switch ($state) {
                    case 'Bavaria':
                        $cities = ['Munich', 'Nuremberg', 'Augsburg'];
                        break;
                    case 'Berlin':
                        $cities = ['Berlin Mitte', 'Charlottenburg', 'Kreuzberg'];
                        break;
                }
                break;

            case 'França':
                switch ($state) {
                    case 'Île-de-France':
                        $cities = ['Paris', 'Boulogne-Billancourt', 'Saint-Denis'];
                        break;
                    case 'Provence-Alpes-Côte d\'Azur':
                        $cities = ['Marseille', 'Nice', 'Toulon'];
                        break;
                }
                break;

            case 'Estados Unidos':
                switch ($state) {
                    case 'California':
                        $cities = ['Los Angeles', 'San Francisco', 'San Diego'];
                        break;
                    case 'Texas':
                        $cities = ['Houston', 'Austin', 'Dallas'];
                        break;
                }
                break;

            case 'Canadá':
                switch ($state) {
                    case 'Ontario':
                        $cities = ['Toronto', 'Ottawa', 'Hamilton'];
                        break;
                    case 'Quebec':
                        $cities = ['Montreal', 'Quebec City', 'Laval'];
                        break;
                }
                break;

            case 'Brasil':
                switch ($state) {
                    case 'São Paulo':
                        $cities = ['São Paulo', 'Campinas', 'Santos'];
                        break;
                    case 'Rio de Janeiro':
                        $cities = ['Rio de Janeiro', 'Niterói', 'Petrópolis'];
                        break;
                }
                break;

            case 'Argentina':
                switch ($state) {
                    case 'Buenos Aires':
                        $cities = ['Buenos Aires', 'La Plata', 'Mar del Plata'];
                        break;
                    case 'Cordoba':
                        $cities = ['Córdoba', 'Villa Carlos Paz', 'Río Cuarto'];
                        break;
                }
                break;

            case 'Austrália':
                switch ($state) {
                    case 'New South Wales':
                        $cities = ['Sydney', 'Newcastle', 'Wollongong'];
                        break;
                    case 'Victoria':
                        $cities = ['Melbourne', 'Geelong', 'Ballarat'];
                        break;
                }
                break;

            case 'Nova Zelândia':
                switch ($state) {
                    case 'Auckland':
                        $cities = ['Auckland Central', 'Manukau', 'Devonport'];
                        break;
                    case 'Wellington':
                        $cities = ['Wellington Central', 'Lower Hutt', 'Petone'];
                        break;
                }
                break;

            case 'República de Antártida':
                switch ($state) {
                    case 'Região Oeste':
                        $cities = ['West Base 1', 'West Base 2'];
                        break;
                    case 'Região Leste':
                        $cities = ['East Base 1', 'East Base 2'];
                        break;
                }
                break;

            case 'Território Antártico Austral':
                switch ($state) {
                    case 'Base McMurdo':
                        $cities = ['McMurdo Station'];
                        break;
                    case 'Base Amundsen-Scott':
                        $cities = ['Amundsen-Scott South Pole Station'];
                        break;
                }
                break;

            default:
                $cities = ['Cidade A', 'Cidade B', 'Cidade C'];
                break;
        }

        return $cities;
    }
}
