<?php

namespace App\Application\Security\Authorization;

use App\Domain\Contract\Verification\VerifyUserCredentialsInterface;
use App\Domain\Entity\User;

class VerifyUserCredentials implements VerifyUserCredentialsInterface
{
    public function verify(User $user, string $username, string $password): bool
    {
        return $user->getUsername() === $username
            && $user->getPassword() === $password;
    }
}
