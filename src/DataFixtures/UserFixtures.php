<?php
// src/DataFixtures/UserFixtures.php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // Définition des utilisateurs à créer
        $usersData = [
            // [ firstName, lastName, email, plainPassword, roleReferenceKey ]
            ['Admin', 'User', 'admin@example.com', 'adminpass', RoleFixtures::ROLE_ADMIN],
            ['Chef',  'Service', 'chef@example.com',  'chefpass',  RoleFixtures::ROLE_CHEF],
            ['Agent', 'One',     'agent@example.com','agentpass', RoleFixtures::ROLE_AGENT],
        ];

        foreach ($usersData as [$first, $last, $email, $plainPass, $roleRef]) {
            $user = new User();
            $user
                ->setFirstName($first)
                ->setLastName($last)
                ->setEmail($email)
                ->setPassword(
                    $this->passwordHasher->hashPassword($user, $plainPass)
                )
                // Initialise le champ JSON 'roles'
                ->setRoles([$roleRef])
                // Lie l'entité Role via la référence définie dans RoleFixtures
                ->setRole($this->getReference($roleRef));

            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        // Assure que RoleFixtures se charge avant UserFixtures
        return [
            RoleFixtures::class,
        ];
    }
}
