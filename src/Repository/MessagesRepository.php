<?php

namespace App\Repository;

use App\Entity\Messages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Messages>
 *
 * @method Messages|null find($id, $lockMode = null, $lockVersion = null)
 * @method Messages|null findOneBy(array $criteria, array $orderBy = null)
 * @method Messages[]    findAll()
 * @method Messages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Messages::class);
    }

    public function save(Messages $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Messages $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Users[] contenant les messages de discussion avec l'interloculeur
     */
    public function findMessages($sender_id, $recepient_id){
        return $this->createQueryBuilder('m')
                // NB: le sender peut aussi etre le recepient ou le recepient etre le sender
                ->andWhere('m.sender_id = :s_id AND m.recepient_id = :r_id OR m.sender_id = :r_id AND m.recepient_id = :s_id')
                ->setParameter('s_id', $sender_id)
                ->setParameter('r_id', $recepient_id)
                ->orderBy('m.id', 'ASC')
                ->getQuery()
                ->getResult()    
        ;
    }

    /**
     * recupere tous les discussions faites par le user connecter
     * @return Messages[]
     */
    public function findUserDiscussions(int $id){
        return $this->createQueryBuilder('m')
            ->andWhere('m.sender_id = :id OR m.recepient_id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * get all discussions did with others
     * @return null|Messages[]
     */
    public function findLastMessage(int $s_id, int $r_id){
        $messages = $this->createQueryBuilder('m')
                ->andWhere('m.sender_id = :s_id AND m.recepient_id = :r_id OR m.sender_id = :r_id AND m.recepient_id = :s_id')
                ->setParameter('s_id', $s_id)
                ->setParameter('r_id', $r_id)
                ->orderBy('m.id', 'ASC')
                ->getQuery()
                ->getResult()  
        ;
        if($messages){
            return $messages[count($messages) -1];
        }
        return null;
    }
    
}
