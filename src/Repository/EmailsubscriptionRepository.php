<?php

namespace App\Repository;

use App\Entity\Emailsubscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Emailsubscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emailsubscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emailsubscription[]    findAll()
 * @method Emailsubscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailsubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emailsubscription::class);
    }

    // /**
    //  * @return Emailsubscription[] Returns an array of Emailsubscription objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Emailsubscription
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findEmailsubscriptionByEmail($email)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.email = :val')
            ->setParameter('val', $email)
            ->getQuery()
            ->getResult()
        ;
    }
}
