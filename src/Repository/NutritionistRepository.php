<?php

namespace App\Repository;

use App\Entity\Nutritionist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Nutritionist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nutritionist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nutritionist[]    findAll()
 * @method Nutritionist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NutritionistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nutritionist::class);
    }

    // /**
    //  * @return Nutritionist[] Returns an array of Nutritionist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Nutritionist
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
