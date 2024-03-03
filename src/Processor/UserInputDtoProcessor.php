<?php

namespace App\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\UserInputDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserInputDtoProcessor implements ProcessorInterface
{
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if (!($data instanceof UserInputDto)) {
            return;
        }
        $user = new User();
        $this->mapDtoToEntity($data, $user);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    private function mapDtoToEntity(UserInputDto $dto, User $user): void {
        $user->setEmail($dto->getUsername());
        $user->setPasswd($this->passwordHasher->hashPassword($user, $dto->getPassword()));

    }
}