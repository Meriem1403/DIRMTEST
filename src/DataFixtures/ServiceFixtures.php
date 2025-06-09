<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $serviceIT = new Service();
        $serviceIT->setName('Informatique');
        $serviceIT->setCode('IT');
        $serviceIT->setCategory('Support');
        $manager->persist($serviceIT);
        $this->addReference('service_it', $serviceIT);

        $serviceRH = new Service();
        $serviceRH->setName('Ressources Humaines');
        $serviceRH->setCode('RH');
        $serviceRH->setCategory('Support');
        $manager->persist($serviceRH);
        $this->addReference('service_rh', $serviceRH);

        $manager->flush();
    }
}
