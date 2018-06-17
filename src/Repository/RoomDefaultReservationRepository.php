<?php

namespace App\Repository;

use App\Entity\RoomDefaultReservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RoomDefaultReservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoomDefaultReservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoomDefaultReservation[]    findAll()
 * @method RoomDefaultReservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomDefaultReservationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RoomDefaultReservation::class);
    }

//    /**
//     * @return RoomDefaultReservation[] Returns an array of RoomDefaultReservation objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RoomDefaultReservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
