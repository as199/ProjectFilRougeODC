<?php

namespace App\Repository;

use App\Entity\CompepenceValides;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompepenceValides|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompepenceValides|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompepenceValides[]    findAll()
 * @method CompepenceValides[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompepenceValidesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompepenceValides::class);
    }

    // /**
    //  * @return CompepenceValides[] Returns an array of CompepenceValides objects
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
    public function findOneBySomeField($value): ?CompepenceValides
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
