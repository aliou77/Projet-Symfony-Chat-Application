<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, UsersRepository $repo): Response
    {

        if($this->getUser() == null){
            // si aucun utilisateur est connecter on le renvoie vers la page de login
            return $this->redirectToRoute("login");
        }
        /** @var Users */
        $user = $this->getUser();
        $contacts = $repo->findUsersByOrder($user->getId());

        return $this->render('pages/index.html.twig', [
            'controller_name' => 'HomePageController',
            'contacts' => $contacts,
            'user' => $this->getUser(),
        ]);
    }

    /**
     * chemin pour recuperer les messages des users
     */
    #[Route("/message-user-{id}", 'user.message')]
    public function message(){
        
    }

    // #[Route('/contact', name: 'contact')]
    // public function contact(UsersRepository $repo): Response
    // {
    //     // render only json data
    //     // return $this->json(['data' => 'bonjour guys']);
    //     $contacts = $repo->findUsersByOrder();
    //     // $sort = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 
    //     //             'y', 'z'];
    //     return new JsonResponse([
    //         'content' => $this->renderView('pages/contact.html.twig', [
    //             'contacts' => $contacts,
    //             // 'sort' => $sort,
    //             ])
    //     ]);
    // }

    // #[Route('/profile', name: 'profile')]
    // public function profile(): Response{

    //     return new JsonResponse([
    //         'content' => $this->renderView('pages/profile.html.twig', [
    //                 'user' => $this->getUser(),
    //         ])
    //     ]);
    // }

}
