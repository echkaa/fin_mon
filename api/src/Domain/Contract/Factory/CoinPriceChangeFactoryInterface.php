<?php

namespace App\Domain\Contract\Factory;

use App\Domain\Entity\Coin;
use App\Domain\Entity\CoinPriceChange;

interface CoinPriceChangeFactoryInterface
{
    public function getInstance(): CoinPriceChange;

    public function getFuturesCoinPriceChangeFromOld(
        ?CoinPriceChange $oldEntity,
        Coin $coin,
        float $marketPrice,
        string $timeRange
    ): CoinPriceChange;
}
