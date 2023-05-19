<?php

namespace App\Service;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Security; // c'est le composant qui recupere le user authentifier getUser()

class ServiceUsers{

    private $em;

    private $userRepo;

    public function __construct(EntityManagerInterface $em, UsersRepository $userRepo)
    {
        $this->em = $em;
        $this->userRepo = $userRepo;
    }

    /**
     * @param array $datas contient les donnees poster via l'ajax ($_POST)
     * @return bool true si tout se passe bien
     */
    public function persistUser(array $datas, Users $user): bool{
        if($this->isVerified($datas)){
            extract($datas);
        
            // on update tous les champs du user (user courant qui s'est connecter)
            $user
                ->setFname($fname)
                ->setLname($lname)
                ->setEmail($email)
                ->setDescription($description)
                ;
                // persiste l'utilisateur apres avoir set tous ces champs
                $this->userRepo->save($user, true);
            
            return true;
        }
        return false;

            // to update profile and back images but can't don't have tmp_path with ajax
            // if((isset($p_img) && !empty($p_img))){
                // $filename= $request->files->get('file');
                // $uploadedFile = new UploadedFile($path, $filename, "image/png", null, true);
                // $entity->setAttach($uploadedFile);
            //     $up = new UploadedFile();
            //     $user->setProfileImg('');
            // }
            // if((isset($b_img) && !empty($b_img))){
            //     $user->setBackImg('');
            // }
    }

    public function persistProfileImg($datas, Users $user){
        extract($datas);
        if($this->isVerified($datas) && !empty($datas['imgName'])){
            $ext = strchr($imgName, '.');
            $newName = explode('.', $_POST['imgName'])[0]. md5(strchr($imgName, '.')) . $ext;
            $user->setProfileImg($newName);
            // move_uploaded_file()
            // persiste l'utilisateur apres avoir set tous ces champs
            $this->userRepo->save($user, true);

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