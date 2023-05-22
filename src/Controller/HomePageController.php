<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\MessagesRepository;
use App\Repository\UsersRepository;
use App\Service\ServiceMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ServiceMessage $servMsg, UsersRepository $userRepo): Response
    {
        if($this->getUser() == null){
            // si aucun utilisateur est connecter on le renvoie vers la page de login
            return $this->redirectToRoute("login");
        }
        /** @var Users */
        $user = $this->getUser();
        
        $contacts = $userRepo->findUsersByOrder($user->getId());
        // get discussions 
        $discussions = $servMsg->getDiscussions($user);

        return $this->render('pages/index.html.twig', [
            'controller_name' => 'HomePageController',
            'contacts' => $contacts,
            'user' => $user,
            'discussions' => ($discussions == null) ? null : $discussions,
        ]);
    }

    #[Route('/body-chat', 'body.chat')]
    public function bodyChat(Request $request, MessagesRepository $repo, UsersRepository $userRepo){
        if($request->isXmlHttpRequest()){
            $r_id = $request->get('data')['r_id'];
            $s_id = $request->get('data')['s_id'];
            $messages = $repo->findMessages($s_id, $r_id);
            $user = $userRepo->find($r_id);
            return new JsonResponse([
                'content' => $this->renderView("pages/body-chat.html.twig", [
                    'messages' => $messages,
                    'user' => $user,
                ])
            ]);
        }
    }

    // exemple d'utilisation de mercure
    #[Route("/ping", 'ping', methods: ["POST"])]
    public function ping(Publisher $publisher){ 
        // #NB: les data doivent etre serializer => la serialisation c'est de transformer des donnees en json
        $update = new Update('http://chat-app.com/chat', "[salut je suis la data]");
        
        // publisher permet d'envoyer l'update a notre hub
        $publisher($update);

        // ici on envoie des donneer depuis le server vers notre client qui est le navigateur avec le $publisher($update);
        // et les donnee seront receptionner et traiter par le code JS mit en bas du base.html.twig

        // -----------------------
        // puis rediriger vers le home
        return $this->redirectToRoute('home');
    }
    #[Route("/test", 'ping')]
    public function test(UsersRepository $userRepo, MessagesRepository $msgRepo, ServiceMessage $serv){
        /** @var Users */
        $user = $this->getUser();
        // $users = $userRepo->findUsersDiscussion();
        // foreach($users as $u){
        //     $msg = $msgRepo->findLastMessage($u['s'], $u['r']);
        //     $s = $u['s'] != $user->getId() ? $userRepo->find($u['s']) : $u['s'];
        //     $r = $u['r'] != $user->getId() ? $userRepo->find($u['r']) : $u['r'];
        //     $discusions[] = [
        //         'message' => $msg,
        //         's' => $s, // sender
        //         'r' => $r, // recepient
        //     ];
            
        // }
        $ids = $userRepo->findUsersIds($user->getId());
        // foreach($ids as $id){
        //     // get the las message with all users whom connected discuss with
        //     /** @var Messages */
        //     $msg = $msgRepo->findLastMessage($user->getId(), $id['id']);
        //     if($msg){
        //         $connectedId = $user->getId();
        //         // if user isn't the connected one we get his instance from UsersRepository
        //         $s = $msg->getSenderId() instanceof Users ? $msg->getSenderId() : $userRepo->find($msg->getSenderId());
        //         $r = $msg->getRecepientId() instanceof Users ? $msg->getRecepientId() : $userRepo->find($msg->getRecepientId());
        //         // if connected have been chat with someone we store details
        //         $discusions[] = [
        //             'sender' => $s,
        //             'recepient' => $r,
        //             'msg' => $msg->getMessage()
        //         ];
        //     }
        // }

        $discusions = $serv->getDiscussions($user);
        dd($discusions);
       
    }


}
