<?php

namespace App\Repository;

use App\Entity\Villes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Villes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Villes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Villes[]    findAll()
 * @method Villes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VillesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Villes::class);
    }

    // /**
    //  * @return Villes[] Returns an array of Villes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Villes
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findVilleByTitre($titre,$id_departement)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.titre = :val')
            ->andWhere('v.departements = :val2')
            ->setParameter('val', $titre)
            ->setParameter('val2', $id_departement)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findVilleByIdTitre($id,$titre,$id_departement)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.titre = :val')
            ->andWhere('v.departements = :val2')
            ->andWhere('v.id != :val3')
            ->setParameter('val', $titre)
            ->setParameter('val2', $id_departement)
            ->setParameter('val3', $id)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findVillesByDepartement($id_departement)
    {
        return $this->createQueryBuilder('v')
            ->select('v.id','v.titre')
            ->andWhere('v.departements = :val')
            ->setParameter('val', $id_departement)
            ->getQuery()
            ->getResult()
        ;
    }
}
