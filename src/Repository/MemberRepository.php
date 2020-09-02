<?php

namespace App\Repository;

use App\Entity\Member;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Member|null find($id, $lockMode = null, $lockVersion = null)
 * @method Member|null findOneBy(array $criteria, array $orderBy = null)
 * @method Member[]    findAll()
 * @method Member[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Member::class);
    }


    public function findAllInAscOrder()
    {
        $qb = $this->createQueryBuilder('mem')
        ->add('orderBy', ['mem.lastname ASC, mem.firstname ASC'])
        ->getQuery();
        return $qb->execute();
        
    }

    
    public function findByName($search)
    {
        $qb = $this->createQueryBuilder('m')
        ->where('m.firstname LIKE :search OR m.lastname LIKE :search')
        ->setParameter('search',  '%' . $search .'%')
        ->getQuery();
        return $qb->execute();
        
    }

    public function findAllWorkers()
    {
        $qb = $this->createQueryBuilder('w')
        ->andWhere('w.job != :null')->setParameter('null', serialize(null)) 
        ->getQuery();
        return $qb->execute();
        
    }

    public function findAllMembers()
    {
        $qb = $this->createQueryBuilder('m')
        ->andWhere('m.job = :null')->setParameter('null', serialize(null)) 
        ->getQuery();
        return $qb->execute();
        
    }
    
}
