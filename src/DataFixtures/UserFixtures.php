<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Role;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFirstName('Alice');
        $user->setLastName('Durand');
        $user->setEmail('alice@example.com');
        $user->setPassword('password');

        $user->setRole($this->getReference('role_role_user', Role::class));
        $user->setService($this->getReference('service_it', Service::class));

        $manager->persist($user);
        $manager->flush();

        $this->addReference('user_alice', $user);
    }

    public function getDependencies(): array
    {
        return [
            RoleFixtures::class,
            ServiceFixtures::class,
        ];
    }
}
