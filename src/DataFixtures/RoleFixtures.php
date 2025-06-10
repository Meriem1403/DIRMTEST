<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public const ROLES = [
        'ROLE_ADMIN' => 'Administrateur',
        'ROLE_AGENT' => 'Agent',
        'ROLE_CHEF' => 'Chef de service',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::ROLES as $name => $label) {
            $role = new Role();
            $role->setName($name);
            $role->setLabel($label);
            $role->setHierarchy([]);

            $manager->persist($role);

            // Utile pour les autres fixtures (UserFixtures, etc.)
            $this->addReference($name, $role);
        }

        $manager->flush();
    }
}
