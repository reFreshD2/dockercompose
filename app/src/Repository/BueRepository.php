<?php

namespace App\Repository;

use App\Entity\Bue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bue|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bue|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bue[]    findAll()
 * @method Bue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bue::class);
    }

    // /**
    //  * @return Bue[] Returns an array of Bue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bue
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
