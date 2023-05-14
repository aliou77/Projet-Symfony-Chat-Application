<?php 

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormsController extends AbstractController{


    #[Route('/form-contact', 'form.contact')]
    public function formContact(Request $request, UsersRepository $repo){

        
        if($request->isXmlHttpRequest()){
            
            $contacts = $repo->findBySearchTerm($request->get('searchTerm'));
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
}