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
   public function findBySearchTerm(string $search, $userId){
        return $this->createQueryBuilder('u')
            ->Where('u.fname LIKE :search OR u.lname LIKE :search')
            ->andWhere('u.id != :u_id')
            ->setParameter('search', '%'.$search.'%')
            ->setParameter('u_id', $userId)
            ->getQuery()
            ->getResult()
        ;
   }

   /**
    * renvoie touts les users qui ont eu une discussion avec le user connecter
    */
   public function findUsersDiscussion(){
        $db = $this->createQueryBuilder('u')
            ->select('DISTINCT u.id , m.recepient_id')
            ->leftJoin('u.messages', 'm') // on join a la table messages (ici representer par la property messages qui est dans Users)
            ->andWhere('m.recepient_id = 16 OR m.sender_id = 16')
            ->getQuery() // returner le getQuery et le dumper pour voir la composition de la requett
            ;
        $ids = $db->getResult();
        $users = [];
        
        foreach($ids as $id){
            $users[] = [
                's' => $id['id'],
                'r' => $id['recepient_id']
            ]; 
        }
        return $users;
   }

   /**
    * recupere les ids des users qui chat avec le user connecte
    * @return array contenant les ids des users a l'exeption de celui qui est connecte
    */
   public function findUsersIds($id){
        return $this->createQueryBuilder('u')
                ->select('u.id')
                ->Where('u.id != :id')
                ->setParameter('id' , $id)
                ->getQuery()
                ->getResult()
            ;
   }
}
