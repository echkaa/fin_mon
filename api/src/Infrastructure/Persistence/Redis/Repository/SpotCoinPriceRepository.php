<?php

namespace App\Infrastructure\Persistence\Redis\Repository;

use App\Domain\Contract\Repository\SpotCoinPriceRepositoryInterface;

class SpotCoinPriceRepository extends AbstractRepository implements SpotCoinPriceRepositoryInterface
{
    function getPrefix(): string
    {
        return "spot_coin-price";
    }
}
