<?php

namespace App\Repository;

use App\Entity\UserExtension;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserExtension|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserExtension|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserExtension[]    findAll()
 * @method UserExtension[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserExtensionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserExtension::class);
    }

//    /**
//     * @return UserExtension[] Returns an array of UserExtension objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserExtension
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
