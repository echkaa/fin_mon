<?php

namespace App\Application\Repository;

use App\Domain\Contract\Repository\UserRepositoryInterface;
use App\Domain\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getByClientId(string $clientId): ?User
    {
        return (new User())
            ->setClientId($clientId)
            ->setUsername('oleksii_kava')
            ->setPassword('mypassword');
    }
}
