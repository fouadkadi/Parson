<?php

namespace App\Repository;

use App\Entity\Profs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Profs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profs[]    findAll()
 * @method Profs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profs::class);
    }

    // /**
    //  * @return Profs[] Returns an array of Profs objects
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
    public function findOneBySomeField($value): ?Profs
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
