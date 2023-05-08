<?php

namespace App\Repository;

use App\Entity\UsersDeleted;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UsersDeleted>
 *
 * @method UsersDeleted|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersDeleted|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersDeleted[]    findAll()
 * @method UsersDeleted[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersDeletedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersDeleted::class);
    }

    public function save(UsersDeleted $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UsersDeleted $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UsersDeleted[] Returns an array of UsersDeleted objects
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

//    public function findOneBySomeField($value): ?UsersDeleted
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
