<?php

namespace App\Repository;

use App\Entity\IndividualVisit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IndividualVisit|null find($id, $lockMode = null, $lockVersion = null)
 * @method IndividualVisit|null findOneBy(array $criteria, array $orderBy = null)
 * @method IndividualVisit[]    findAll()
 * @method IndividualVisit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IndividualVisitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IndividualVisit::class);
    }

    // /**
    //  * @return IndividualVisit[] Returns an array of IndividualVisit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IndividualVisit
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
