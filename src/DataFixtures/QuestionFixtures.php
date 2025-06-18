<?php
// src/DataFixtures/QuestionFixtures.php

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Mobilité
        $q1 = (new Question())
            ->setSubmissionType('mobility')
            ->setLabel('Quel est votre service actuel ?')
            ->setType('choice')
            ->setRequired(true)
            ->setOrderIndex(1)
            ->setOptions(['Service A','Service B','Service C']);
        $manager->persist($q1);

        $q2 = (new Question())
            ->setSubmissionType('mobility')
            ->setLabel('Date de prise de fonction')
            ->setType('date')
            ->setRequired(true)
            ->setOrderIndex(2)
            ->setOptions(null);
        $manager->persist($q2);

        // Accès aux outils
        $q3 = (new Question())
            ->setSubmissionType('access')
            ->setLabel('Quel outil souhaitez-vous ?')
            ->setType('choice')
            ->setRequired(true)
            ->setOrderIndex(1)
            ->setOptions(['Cerbère','Mailpit','Autre']);
        $manager->persist($q3);

        // Mise en chantier
        $q4 = (new Question())
            ->setSubmissionType('worksite')
            ->setLabel('Nom du navire')
            ->setType('text')
            ->setRequired(true)
            ->setOrderIndex(1)
            ->setOptions(null);
        $manager->persist($q4);

        $q5 = (new Question())
            ->setSubmissionType('worksite')
            ->setLabel('Date de début')
            ->setType('date')
            ->setRequired(true)
            ->setOrderIndex(2)
            ->setOptions(null);
        $manager->persist($q5);

        $manager->flush();
    }
}
