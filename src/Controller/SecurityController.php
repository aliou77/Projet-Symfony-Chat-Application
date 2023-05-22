<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\InscriptionType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('connexion/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/signup', name: 'signup')]
    public function signup(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $users = new Users();
        $form = $this->createForm(InscriptionType::class, $users);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            // we persiste data in db
            // hash le password avant de le persister
            $password = $form->getData()->getPassword();
            $hashpass = $hasher->hashPassword($users, $password); // il accepte $users parce qu'il implemente la \Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface 
           
            $users
                ->setPassword($hashpass)
                ->setStatus(false);
            $em->persist($users);
            $em->flush();
            // dd($form->getData()->getPassword());
        }
        // dd($form->createView());
        return $this->render('connexion/signup.html.twig', [
            'controller_name' => 'SignInController',
            'form' => $form->createView()
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(UsersRepository $repo): void
    {
        /** @var Users */
        $user = $this->getUser();
        $user->setStatus(false);
        $repo->save($user, true);
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
