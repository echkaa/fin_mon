<?php

namespace App\Infrastructure\Persistence\Redis\Repository;

class CoinPriceRepository extends AbstractRepository
{
    function getPrefix(): string
    {
        return "coin-price";
    }
}
