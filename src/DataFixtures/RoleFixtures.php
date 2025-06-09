<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $roleUser = new Role();
        $roleUser->setName('ROLE_USER');
        $roleUser->setLabel('Utilisateur');
        $manager->persist($roleUser);
        $this->addReference('role_role_user', $roleUser);

        $roleAdmin = new Role();
        $roleAdmin->setName('ROLE_ADMIN');
        $roleAdmin->setLabel('Administrateur');
        $manager->persist($roleAdmin);
        $this->addReference('role_role_admin', $roleAdmin);

        $manager->flush();
    }
}
