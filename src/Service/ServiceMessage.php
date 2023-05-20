<?php

namespace App\Service;

use App\Entity\Users;
use App\Repository\MessagesRepository;
use App\Repository\UsersRepository;

class ServiceMessage{

    private $userRepo;

    private $msgRepo;

    public function __construct(MessagesRepository $msgRepo, UsersRepository $userRepo)
    {
        $this->userRepo = $userRepo;
        $this->msgRepo = $msgRepo;
    }
    public function getDiscussions(Users $user){
        $ids = $this->userRepo->findUsersIds($user->getId());
        foreach($ids as $id){
            // get the las message with all users whom connected discuss with
            /** @var Messages */
            $msg = $this->msgRepo->findLastMessage($user->getId(), $id['id']);
            if($msg){
                // if user isn't the connected one we get his instance from UsersRepository
                // only the connected is an instance of Users in $msg
                $s = $msg->getSenderId() instanceof Users ? $msg->getSenderId() : $this->userRepo->find($msg->getSenderId());
                $r = $msg->getRecepientId() instanceof Users  ? $msg->getRecepientId() : $this->userRepo->find($msg->getRecepientId());
                
                $discusions[] = [
                    'sender' => $s,
                    'recepient' => $r,
                    'msg' => $msg->getMessage()
                ];
            }
        }

        return $discusions;
    }
}