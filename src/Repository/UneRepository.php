<?php

namespace App\Repository;

use App\Entity\Une;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Une|null find($id, $lockMode = null, $lockVersion = null)
 * @method Une|null findOneBy(array $criteria, array $orderBy = null)
 * @method Une[]    findAll()
 * @method Une[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Une::class);
    }

    // /**
    //  * @return Une[] Returns an array of Une objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Une
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
