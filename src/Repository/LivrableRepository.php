<?php

namespace App\Repository;

use App\Entity\Livrable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livrable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livrable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livrable[]    findAll()
 * @method Livrable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivrableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livrable::class);
    }
    public function findByLivId($id)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.id = :val')
            ->andWhere('l = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Livrable[] Returns an array of Livrable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Livrable
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
