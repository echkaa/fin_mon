<?php

namespace App\Domain\Contract\Verification;

use App\Domain\Entity\User;

interface VerifyUserCredentialsInterface
{
    function verify(User $user, string $password): bool;
}
