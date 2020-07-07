<?php

namespace App\Repository;

use App\Entity\OnlineForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OnlineForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method OnlineForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method OnlineForm[]    findAll()
 * @method OnlineForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OnlineFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OnlineForm::class);
    }

    // /**
    //  * @return OnlineForm[] Returns an array of OnlineForm objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OnlineForm
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
