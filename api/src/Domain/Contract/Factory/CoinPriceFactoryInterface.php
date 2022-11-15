<?php

namespace App\Domain\Contract\Factory;

use App\Domain\Entity\Coin;
use App\Domain\Entity\CoinPrice;

interface CoinPriceFactoryInterface
{
    public function getInstance(): CoinPrice;

    public function fillEntityForBinanceFutures(CoinPrice $entity, Coin $coin, float $price): CoinPrice;
}
