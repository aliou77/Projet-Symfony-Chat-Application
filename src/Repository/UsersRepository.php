<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Users>
 *
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    public function save(Users $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Users $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Users[] Returns an array of Users objects
    */
   public function findUsersByOrder(int $id): array
   {
       return $this->createQueryBuilder('u')
           ->andWhere("u.id != :id")
           ->setParameter('id', $id)
           ->orderBy('u.fname', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

   /**
    * @return Users[] contenant le resultat de la recherche
    */
   public function findBySearchTerm(string $search){
        return $this->createQueryBuilder('u')
            ->Where('u.fname LIKE :search OR u.lname LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->getQuery()
            ->getResult()
        ;
   }

//    public function findOneBySomeField($value): ?Users
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
