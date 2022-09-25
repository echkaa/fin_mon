<?php

namespace App\Infrastructure\Persistence\MySQL\Repository;

use App\Domain\Contract\Repository\UserRepositoryInterface;
use App\Domain\Entity\User;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    function getEntityClassName(): string
    {
        return User::class;
    }

    public function getByUsername(string $username): ?User
    {
        return $this->findOneBy(['username' => $username]);
    }
}
