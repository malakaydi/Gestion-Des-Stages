<?php

namespace App\Repository;

use App\Entity\Membres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Membres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Membres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Membres[]    findAll()
 * @method Membres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MembresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Membres::class);
    }

    // /**
    //  * @return Membres[] Returns an array of Membres objects
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
    public function findOneBySomeField($value): ?Membres
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByType($type)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.type = :val')
            ->setParameter('val', $type)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findMembreByEmail($email)
    {
        return $this->createQueryBuilder('m')
            ->select('m.email')
            ->andWhere('m.email = :val')
            ->setParameter('val', $email)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findMembreByIDEmail($id,$email)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.id != :val')
            ->andWhere('m.email = :val2')
            ->setParameter('val', $id)
            ->setParameter('val2', $email)
            ->getQuery()
            ->getResult()
        ;
    }
   
   
}
