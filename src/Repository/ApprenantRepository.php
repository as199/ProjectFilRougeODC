<?php

namespace App\Repository;

use App\Entity\Apprenant;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Apprenant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apprenant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apprenant[]    findAll()
 * @method Apprenant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApprenantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apprenant::class);
    }

    public function Lister_briefs_apprenants($id,$idp, $idb){
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :id')
            ->setParameter('id', $id)

        

            ->innerJoin('a.groupes', 'g')
            ->andWhere('g.id = :idg')
            ->setParameter('idg', 1)

            /* ->innerJoin('g.promos', 'p')
            ->andWhere('p.id = :idp')
            ->setParameter('idp', $idp) */

            /* ->innerJoin('p.briefMaPromos', 'bp')
            ->andWhere('bp.id = :idbp')
            ->setParameter('idbp', $idb)

            ->innerJoin('bp.briefs', 'b')
            ->andWhere('b.id = :idb')
            ->setParameter('idb', $idb) */

            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Apprenant[] Returns an array of Apprenant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Apprenant
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
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
