<?php

namespace App\Repository;

use App\Entity\UsersBlocked;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UsersBlocked>
 *
 * @method UsersBlocked|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersBlocked|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersBlocked[]    findAll()
 * @method UsersBlocked[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersBlockedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersBlocked::class);
    }

    public function save(UsersBlocked $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UsersBlocked $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UsersBlocked[] Returns an array of UsersBlocked objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UsersBlocked
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
