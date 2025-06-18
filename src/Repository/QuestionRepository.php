<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository as BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

class QuestionRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * Retourne les types de formulaires (mock).
     *
     * @return array<string,string> Label => slug
     */
    public function getMockSubmissionTypes(): array
    {
        return [
            'Mobilité' => 'mobility',
            'Accès'    => 'access',
            'Chantier' => 'worksite',
        ];
    }

    /**
     * Retourne les types de champ pour les questions.
     *
     * @return array<string,string> Label => type
     */
    public function getTypeChoices(): array
    {
        return [
            'Texte'         => 'text',
            'Zone de texte' => 'textarea',
            'Email'         => 'email',
            'Nombre'        => 'number',
            'Date'          => 'date',
            'Choix'         => 'choice',
            'Fichier'       => 'file',
        ];
    }
// /**
    //  * @return Question[] Returns an array of Question objects
    //  */
    // public function findByExampleField($value): array
    // {
    //     return $this->createQueryBuilder('q')
    //         ->andWhere('q.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('q.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    // public function findOneBySomeField($value): ?Question
    // {
    //     return $this->createQueryBuilder('q')
    //         ->andWhere('q.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
}
