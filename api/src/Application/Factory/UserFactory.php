<?php

namespace App\Application\Factory;

use App\Application\Command\Auth\Registration\RegistrationCommand;
use App\Domain\Contract\Factory\UserFactoryInterface;
use App\Domain\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory implements UserFactoryInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function getInstance(): User
    {
        return new User();
    }

    public function fillEntity(User $entity, RegistrationCommand $command): User
    {
        $hashedPassword = $this->passwordHasher->hashPassword($entity, $command->getPassword());

        return $entity->setUsername($command->getUsername())
            ->setPassword($hashedPassword);
    }
}
