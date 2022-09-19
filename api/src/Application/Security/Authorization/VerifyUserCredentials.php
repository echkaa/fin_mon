<?php

namespace App\Application\Security\Authorization;

use App\Domain\Contract\Verification\VerifyUserCredentialsInterface;
use App\Domain\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class VerifyUserCredentials implements VerifyUserCredentialsInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function verify(User $user, string $password): bool
    {
        return $this->passwordHasher->isPasswordValid($user, $password);
    }
}
