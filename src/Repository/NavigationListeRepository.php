<?php

namespace App\Repository;

use App\Entity\NavigationListe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NavigationListe|null find($id, $lockMode = null, $lockVersion = null)
 * @method NavigationListe|null findOneBy(array $criteria, array $orderBy = null)
 * @method NavigationListe[]    findAll()
 * @method NavigationListe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NavigationListeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NavigationListe::class);
    }

    // /**
    //  * @return NavigationListe[] Returns an array of NavigationListe objects
    //  */
    /*
    
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NavigationListe
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findByNav($navigation)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.navigation = :val')
            ->setParameter('val', $navigation)
           
            ->getQuery()
            ->getResult()
        ;
    }

  

    public function findnavigationByTitre($titre)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.titre = :val')
            ->setParameter('val', $titre)
            ->getQuery()
            ->getResult()
        ;
    }
}
