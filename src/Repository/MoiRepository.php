<?php

namespace App\Repository;

use App\Entity\Moi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Moi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Moi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Moi[]    findAll()
 * @method Moi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Moi::class);
    }

    // /**
    //  * @return Moi[] Returns an array of Moi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Moi
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
