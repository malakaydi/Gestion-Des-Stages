<?php

namespace App\Repository;

use App\Entity\Navigation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Navigation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Navigation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Navigation[]    findAll()
 * @method Navigation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NavigationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Navigation::class);
    }

    // /**
    //  * @return Navigation[] Returns an array of Navigation objects
    //  */
    
    public function findById($idNavigation)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.id = :val')
            ->setParameter('val', $idNavigation)
           
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Navigation
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findnavigationBytitre($titre)
    {
        return $this->createQueryBuilder('m')
            ->select('m.titre')
            ->andWhere('m.titre = :val')
            ->setParameter('val', $titre)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findNameById($id)
    {
        return $this->createQueryBuilder('n')
            ->select('n.titre')
            ->andWhere('n.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult()
        ;
    }
    
    // public function findByactif($actif)
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.actif = :1')
    //         ->setParameter('val', $actif)
    //         // ->orderBy('c.ordre', 'ASC')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
}
