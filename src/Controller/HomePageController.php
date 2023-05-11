<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {

        return $this->render('pages/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(UsersRepository $repo): Response
    {
        // render only json data
        // return $this->json(['data' => 'bonjour guys']);
        $contacts = $repo->findUsersByOrder();
        $sort = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 
                    'y', 'z'];
        // dd($this->getUser());
        // return a jsonView
        return new JsonResponse([
            'content' => $this->renderView('pages/contact.html.twig', [
                'contacts' => $contacts,
                'sort' => $sort,
                ])
        ]);
    }

}
