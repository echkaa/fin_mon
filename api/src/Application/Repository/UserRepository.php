<?php

namespace App\Application\Repository;

use App\Domain\Contract\Repository\UserRepositoryInterface;
use App\Domain\Entity\User;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    function getEntityClassName(): string
    {
        return User::class;
    }

    public function getByClientId(string $clientId): ?User
    {
        return $this->findOneBy(['client_id' => $clientId]);
    }
}
