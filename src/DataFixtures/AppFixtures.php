<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Location;
use App\Entity\Person;
use App\Service\CallApiService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\DBAL\Connection as DBALConnection;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $connection;

    public function __construct(DBALConnection $connection, SluggerInterface $slugger, CallApiService $api)
    {
        $this->connection = $connection;
        $this->slugger = $slugger;
        $this->api = $api;
    }

    /**
     * Permet de TRUNCATE les tables et de remettre les Auto-incréments à 1
     */
    private function truncate()
    {
        $this->connection->executeQuery('SET foreign_key_checks = 0');

        $this->connection->executeQuery('TRUNCATE TABLE episode');
        $this->connection->executeQuery('TRUNCATE TABLE location');
        $this->connection->executeQuery('TRUNCATE TABLE person');
        $this->connection->executeQuery('TRUNCATE TABLE person_episode');

        $this->connection->executeQuery('SET foreign_key_checks = 1');
    }

    /**
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $this->truncate();
        # Character
        $personsList = [];

        for ($i=1; $i <= 42 ; $i++) 
        {
            $personApi = $this->api->fetchDataCharacterApi($i);

            foreach ($personApi['results'] as $value) 
            {
                $person = new Person();
                $person->setName($value['name']);
                $person->setStatus($value['status']);
                $person->setSpecies($value['species']);
                $person->setType($value['type']);
                $person->setGender($value['gender']);
                $person->setImage($value['image']);
                $person->setSlug($this->slugger->slug($value['name'])->lower());
                $person->setOriginName($value['origin']['name']);
                if ($value['location']['name'] == true) {
                    $person->setLocationName($value['location']['name']);
                } else {
                    $person->setLocationName('Unknown');
                }

                $personsList[] = $person;
                $manager->persist($person);      
            }
        }

        
        #Location
        $locationsList = [];

        for ($i=1; $i <= 7 ; $i++) 
        {
            $locationApi = $this->api->fetchDataLocationApi($i);

            foreach ($locationApi['results'] as $value) 
            {
                $location = new Location();
                $location->setName($value['name']);
                $location->setType($value['type']);
                $location->setDimension($value['dimension']);

                foreach ($personsList as $key => $person) 
                {
                    if ($location->getName() === $person->getLocationName()) 
                    {
                        $location->addLocationPerson($person);
                    }

                    if ($location->getName() === $person->getOriginName()) 
                    {
                        $location->addOriginPerson($person);
                    }
                }
    
                $locationsList[] = $location;
                $manager->persist($location);      
            }
        }

        #Episode
        $episodesList = [];
        
        for ($i=1; $i <= 3 ; $i++) 
        {
            $episodeApi = $this->api->fetchDataEpisodeApi($i);

            foreach ($episodeApi['results'] as $value) 
            {
                $episode = new Episode();
                $episode->setName($value['name']);
                $episode->setAirDate($value['air_date']);
                $episode->setEpisode($value['episode']);

                foreach ($value['characters'] as $key => $data) 
                {
                    $idByExplode = explode("https://rickandmortyapi.com/api/character/", $data);
                    $id = intval($idByExplode[1]);

                    $episode->addPerson($personsList[$id - 1]);
                }
                
                $episodesList[] = $episode;
                $manager->persist($episode);      
            }
        }      

        $manager->flush();
    }
}
