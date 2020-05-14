<?php

namespace App\Repository;

use App\Entity\Instructions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Instructions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Instructions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Instructions[]    findAll()
 * @method Instructions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstructionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Instructions::class);
    }

    // /**
    //  * @return Instructions[] Returns an array of Instructions objects
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
    public function findOneBySomeField($value): ?Instructions
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
