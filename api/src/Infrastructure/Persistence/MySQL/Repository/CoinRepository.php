<?php

namespace App\Infrastructure\Persistence\MySQL\Repository;

use App\Domain\Contract\Repository\CoinRepositoryInterface;
use App\Domain\Entity\Coin;

class CoinRepository extends AbstractRepository implements CoinRepositoryInterface
{
    function getEntityClassName(): string
    {
        return Coin::class;
    }
}
