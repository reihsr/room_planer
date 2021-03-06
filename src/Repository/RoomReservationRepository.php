<?php

namespace App\Repository;

use App\Entity\RoomReservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RoomReservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoomReservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoomReservation[]    findAll()
 * @method RoomReservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomReservationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RoomReservation::class);
    }

//    /**
//     * @return RoomReservation[] Returns an array of RoomReservation objects
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
    public function findOneBySomeField($value): ?RoomReservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllForUserWithDate($userId, $date_start, $date_end) {
        $query_builder = $this->createQueryBuilder('r')
                ->andWhere('r.userId = :userId')
                ->andWhere('r.date BETWEEN :startDate AND :endDate')
                ->setParameter('userId', $userId)
                ->setParameter('startDate', $date_start)
                ->setParameter('endDate', $date_end)
                ->orderBy('r.date', 'ASC')
                ->getQuery();
        return $query_builder->execute();
    }
}
