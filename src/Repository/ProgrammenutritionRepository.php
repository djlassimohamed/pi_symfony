<?php

namespace App\Repository;

use App\Entity\Programmenutrition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Programmenutrition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Programmenutrition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Programmenutrition[]    findAll()
 * @method Programmenutrition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgrammenutritionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Programmenutrition::class);
    }

    // /**
    //  * @return Programmenutrition[] Returns an array of Programmenutrition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Programmenutrition
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
