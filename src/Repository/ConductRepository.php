<?php

namespace App\Repository;

use App\Entity\Conduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Conduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conduct[]    findAll()
 * @method Conduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conduct::class);
    }

    // /**
    //  * @return Conduct[] Returns an array of Conduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Conduct
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
