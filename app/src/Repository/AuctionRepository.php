<?php

namespace App\Repository;

use App\Entity\Auction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Criteria;

/**
 * @method Auction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auction[]    findAll()
 * @method Auction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuctionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auction::class);
    }

    public function getCurrentAuctions()
    {
        $one_week_ago = date('Y-m-d', strtotime('1 week ago'));
        $qb = $this->createQueryBuilder('auctions');
        $qb->where("auctions.date > :one_week_ago");
        $qb->setParameter('one_week_ago',$one_week_ago);
        return $qb->getQuery()->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Auction
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
