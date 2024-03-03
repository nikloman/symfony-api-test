<?php

namespace App\Security;

use App\Entity\Vermittler;
use App\Entity\VermittlerUser;
use App\Repository\VermittlerRepository;
use App\Repository\VermittlerUserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\UserNotFoundException;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\PayloadAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method UserInterface loadUserByIdentifierAndPayload(string $identifier, array $payload)
 */
class VermittlerUserProvider implements PayloadAwareUserProviderInterface
{
    public function __construct(private readonly VermittlerUserRepository $vermittlerUserRepository)
    {
    }

    public function loadUserByUsernameAndPayload(string $username, array $payload): UserInterface
    {
        return $this->loadUserByIdentifier($username);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return VermittlerUser::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->vermittlerUserRepository->findOneBy(['email' => $identifier, 'aktiv' => 1]);
        if (null === $user) {
            throw new \Symfony\Component\Security\Core\Exception\UserNotFoundException('Not found');
        }
        return $user;
    }
}