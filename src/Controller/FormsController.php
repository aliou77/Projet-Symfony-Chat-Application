<?php 

namespace App\Controller;

use App\Entity\Users;
use App\Repository\MessagesRepository;
use App\Repository\UsersRepository;
use App\Service\ServiceForms;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormsController extends AbstractController{

    /**
     * fais une recherche dans les conctact et return les resultats
     */
    #[Route('/form-contact', 'form.contact')]
    public function formContact(Request $request, UsersRepository $repo): Response {

        
        if($request->isXmlHttpRequest()){
            /** @var Users */
            $user = $this->getUser();
            $contacts = $repo->findBySearchTerm($request->get('searchTerm'), $user->getId());
            if(!empty($contacts)){
                return new JsonResponse([
                    'content' => $this->renderView('forms/form-contact.html.twig', [
                        'contacts' => $contacts
                    ]),
                    'status' => 'success'
                ]);
            }else{
                return new JsonResponse([
                    'status' => 'not-found'
                ]);
            }
            
        }
    }

    /**
     * persiste les datas provenant du formulaire d'envoie de message
     */
    #[Route('/form-message-{id}', 'form.message')]
    public function formMessage(Request $request, ServiceForms $serv,int $id, MessagesRepository $msgRepo): Response{
       
         // recupere les message
        if($request->isXmlHttpRequest()){
            /** @var Users */
            $user = $this->getUser();
            if($serv->persistFormMessage($_POST, $user, $id)){ // $id = recepient_id
                $message = $msgRepo->findMessages($user->getId(), $id);
                $lastMsg = $message[count($message)-1];
                return new JsonResponse([
                    // 'content' => $this->renderView('pages/last-message-send.html.twig', [
                    //     'message' => $lastMsg,
                    // ]),
                    'status' => "success",
                ]);
            }else{
                return new JsonResponse(['status' => "failed"]);
            }
        }
    }
    
}