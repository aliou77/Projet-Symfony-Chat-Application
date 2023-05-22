<?php

namespace App\Service;

use App\Entity\Messages;
use App\Entity\Users;
use App\Repository\MessagesRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class ServiceForms {

    private $em;

    private $repo;

    public function __construct(EntityManagerInterface $em, MessagesRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
    }

    public function persistFormMessage(array $datas, Users $user, $recepient_id){
        
        if($this->isVerified($datas)){
            extract($datas);
            // if audio do other traitment 
            $msg = new Messages();
            $msg
                ->setSenderId($user)
                ->setRecepientId($recepient_id)
                ->setMessage($message)
                ->setCreatedAt(new DateTimeImmutable())
            ;
            $this->repo->save($msg, true); 
            return true;
        }
        return false;
    }

    private function isVerified(array $array){
        if(empty($array) || !isset($array)){
            return false;
        }else{
            foreach ($array as $value) {
                if($value == ''){
                    return false;
                }
            }
        }
        return true;
    }
}