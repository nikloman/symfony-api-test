<?php

namespace App\EventListener;

use App\Doctrine\VermittlerUserFilter;
use App\Entity\VermittlerUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[AsEventListener(event: KernelEvents::REQUEST, method: 'onKernelRequest', priority: 4)]
class CurrentVermittlerUserListener
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $user = $this->security->getUser();
        if ($user instanceof VermittlerUser) {
            $this->entityManager->getFilters()
                ->enable(VermittlerUserFilter::VERMITTLER_USER_FILTER)
                ->setParameter(VermittlerUserFilter::VERMITTLER_USER_FILTER, $user->getVermittler()->getId());
        }

    }
}