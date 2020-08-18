<?php

namespace App\Repository;

use App\Entity\Registration;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Registration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Registration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Registration[]    findAll()
 * @method Registration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegistrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Registration::class);
    }

    public function findByDateAsc()
    {
        $qb = $this->createQueryBuilder('r')
            ->innerJoin('r.booking', 'b')
            ->add('orderBy', 'b.beginAt ASC')
            ->getQuery();
        return $qb->execute();
    }


}
