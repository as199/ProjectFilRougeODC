<?php

namespace App\Repository;

use App\Entity\Groupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Groupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Groupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Groupe[]    findAll()
 * @method Groupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Groupe::class);
    }

    public function recupApprenant($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.promos = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }
    public function recupid($value)
    {
        return $this->createQueryBuilder('g')
            ->select('g.apprenants')
            ->andWhere('g.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Groupe[] Returns an array of Groupe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Groupe
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByStatutGroupe($value)
    {
        return $this->createQueryBuilder('g')
            //->innerJoin('p.groupes', 'g')
            ->andWhere('g.statut = :val')
            ->setParameter('val', $value)
            
            ->getQuery()
            ->getResult();
    }

    public function findByStatutGroupeid($value, $id)
    {
        return $this->createQueryBuilder('g')
            //->innerJoin('p.groupes', 'g')
            ->andWhere('g.statut = :val')
            ->setParameter('val', $value)
            ->andWhere('g.id = :id')
            ->setParameter('id', $id)
            
            ->getQuery()
            ->getResult();
    }
}
