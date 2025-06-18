<?php
// src/DataFixtures/ServiceFixtures.php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $serviceLabels = ['Service A', 'Service B', 'Service C'];

        foreach ($serviceLabels as $label) {
            $service = new Service();
            // Code unique non null
            $service->setCode(strtolower(str_replace(' ', '_', $label)))
                ->setName($label)
                ->setLocations([])
                ->setTypes([]);
            $manager->persist($service);
        }

        $manager->flush();
    }
}
