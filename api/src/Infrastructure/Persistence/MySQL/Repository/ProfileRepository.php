<?php

namespace App\Infrastructure\Persistence\MySQL\Repository;

use App\Domain\Contract\Repository\ProfileRepositoryInterface;
use App\Domain\Entity\Profile;

class ProfileRepository extends AbstractRepository implements ProfileRepositoryInterface
{
    function getEntityClassName(): string
    {
        return Profile::class;
    }
}
