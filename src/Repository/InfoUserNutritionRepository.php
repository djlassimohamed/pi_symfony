<?php

namespace App\Repository;

use App\Entity\InfoUserNutrition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InfoUserNutrition|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoUserNutrition|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoUserNutrition[]    findAll()
 * @method InfoUserNutrition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoUserNutritionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfoUserNutrition::class);
    }

    // /**
    //  * @return InfoUserNutrition[] Returns an array of InfoUserNutrition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InfoUserNutrition
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
