<?php

namespace App\Repository;

use App\Entity\Departements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Departements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Departements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Departements[]    findAll()
 * @method Departements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departements::class);
    }


    public function findAllVilles($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Departements[] Returns an array of Departements objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Departements
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findDepartementByTitre($titre)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.titre = :val')
            ->setParameter('val', $titre)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findDepartementByIdTitre($id_departement,$titre)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.id != :val')
            ->andWhere('d.titre = :val2')
            ->setParameter('val', $id_departement)
            ->setParameter('val2', $titre)
            ->getQuery()
            ->getResult()
        ;
    }
    
}
