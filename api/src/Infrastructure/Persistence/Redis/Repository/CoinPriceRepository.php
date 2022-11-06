<?php

namespace App\Infrastructure\Persistence\Redis\Repository;

use App\Domain\Contract\Repository\CoinPriceRepositoryInterface;

class CoinPriceRepository extends AbstractRepository implements CoinPriceRepositoryInterface
{
    function getPrefix(): string
    {
        return "coin-price";
    }
}
