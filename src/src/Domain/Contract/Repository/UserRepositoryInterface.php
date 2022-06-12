<?php

namespace App\Domain\Contract\Repository;

use App\Domain\Entity\User;

interface UserRepositoryInterface extends AbstractRepositoryInterface
{
    function getByClientId(string $clientId): ?User;
}
