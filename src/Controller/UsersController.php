<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\MessagesRepository;
use App\Repository\UsersRepository;
use App\Service\ServiceUsers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users')]
class UsersController extends AbstractController
{
    private $serv;

    public function __construct(ServiceUsers $serv)
    {
        $this->serv = $serv;
    }
    #[Route('/user-edit-{id}', name: 'users.edit', methods: ['POST'])]
    public function edit(Request $request, Users $user): Response
    {
        // dd($this->getUser()->getFname());
        if($request->isXmlHttpRequest()){
            if($this->serv->persistUser($_POST, $user)){
                // si tout se passe bien on renvoie un pt message 

                return new JsonResponse([
                    'status' => "success",
                    'message' => "personal informations have been modified successfully !",
                ]);
            }else{
                // si tout se passe bien on renvoie un pt message 
                return new JsonResponse([
                    'status' => "failed",
                    'message' => "somthing went wrong !",
                ]);
            }
        }
    }

    #[Route('/change-profle-imgs-{id}', name: 'profile-img-change', methods: ['POST'])]
    public function index(Request $request, Users $user): Response
    {
        
        if($request->isXmlHttpRequest()){
            // on persist l'image en DB
            if($this->serv->persistProfileImg($_POST, $user)){
                return new JsonResponse(['status' => "success"]);
            }else{
                return new JsonResponse(['status' => "failed"]);
            }
        }

    }

    #[Route('/message-section-{id}', 'message.section')]
    public function message(Request $request, Users $user,int $id, MessagesRepository $msgRepo){
        // on recupere le user sur sur le quel on a clicker ($user)
        if($request->isXmlHttpRequest()){
            /** @var Users */
            $user_sending = $this->getUser();
            $messages = $msgRepo->findMessages($user_sending->getId(), $id);
            return new JsonResponse([
                'content' => $this->renderView('pages/message-section.html.twig', [
                    'user' => $user,
                    'messages' => $messages,
                ]),
                'status' => 'success'
            ]);
        }
    }


    #[Route('/{id}', name: 'app_users_delete', methods: ['POST'])]
    public function delete(Request $request, Users $user, UsersRepository $usersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $usersRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
    }
}
