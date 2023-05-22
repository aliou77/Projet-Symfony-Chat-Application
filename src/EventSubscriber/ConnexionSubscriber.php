<?php

namespace App\EventSubscriber;

use App\Repository\UsersRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use App\Entity\Users;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Exception\EnvNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ConnexionSubscriber implements EventSubscriberInterface
{
    private $userRepo;

    private $security;

    public function __construct(UsersRepository $userRepo, Security $security)
    {
        $this->userRepo = $userRepo;
        $this->security = $security;
    }

    public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    {
        // if user is logged successfully we update his status to true
        /** @var Users */
        $user = $event->getUser();
        if ($user) {
            $user->setStatus(true);
            $this->userRepo->save($user, true);
        }
    }

    public function onLogoutSuccess(LogoutEvent $event): void
    {
        // if user is logged out successfully we update his status to false
        /** @var Users */
        $user = $this->security->getUser();
        
        if ($user) {
            $user->setStatus(false);
            $this->userRepo->save($user, true);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccessEvent',
            LogoutEvent::class => 'onLogoutSuccess',
        ];
    }
}
