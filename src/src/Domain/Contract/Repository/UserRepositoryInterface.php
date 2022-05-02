<?php

namespace App\Domain\Contract\Repository;

use App\Domain\Entity\User;

interface UserRepositoryInterface
{
    function getByClientId(string $clientId): ?User;
}
