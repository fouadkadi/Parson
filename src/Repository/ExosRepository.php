<?php

namespace App\Repository;

use App\Entity\Exos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Exos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exos[]    findAll()
 * @method Exos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exos::class);
    }

    // /**
    //  * @return Exos[] Returns an array of Exos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Exos
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
