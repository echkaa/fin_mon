<?php

namespace App\Infrastructure\Persistence\Redis\Repository;

use App\Domain\Contract\Repository\FuturesCoinPriceRepositoryInterface;

class FuturesCoinPriceRepository extends AbstractRepository implements FuturesCoinPriceRepositoryInterface
{
    function getPrefix(): string
    {
        return "futures_coin-price";
    }
}
