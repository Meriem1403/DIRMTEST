<?php
// src/DataFixtures/RoleFixtures.php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public const ROLE_ADMIN = 'role_admin';
    public const ROLE_CHEF  = 'role_chef';
    public const ROLE_AGENT = 'role_agent';

    public function load(ObjectManager $manager): void
    {
        $rolesData = [
            self::ROLE_ADMIN => ['name'=>'ROLE_ADMIN', 'label'=>'Administrateur'],
            self::ROLE_CHEF  => ['name'=>'ROLE_CHEF',  'label'=>'Chef de service'],
            self::ROLE_AGENT => ['name'=>'ROLE_AGENT', 'label'=>'Agent'],
        ];

        $repo = $manager->getRepository(Role::class);

        foreach ($rolesData as $refKey => $info) {
            $existing = $repo->findOneBy(['name'=>$info['name']]);
            if ($existing) {
                $this->addReference($refKey, $existing);
                continue;
            }
            $role = new Role();
            $role->setName($info['name'])
                ->setLabel($info['label']);
            $manager->persist($role);
            $this->addReference($refKey, $role);
        }

        $manager->flush();
    }
}
