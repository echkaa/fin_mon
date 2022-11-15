<?php

namespace App\Application\Factory;

use App\Domain\Contract\Factory\CoinPriceFactoryInterface;
use App\Domain\Entity\CoinPrice;
use App\Domain\Entity\Coin;
use DateTime;

class CoinPriceFactory implements CoinPriceFactoryInterface
{
    public function getInstance(): CoinPrice
    {
        return new CoinPrice();
    }

    public function fillEntityForBinanceFutures(CoinPrice $entity, Coin $coin, float $price): CoinPrice
    {
        return $entity
            ->setMarketPrice($price)
            ->setCoin($coin)
            ->setSource(CoinPrice::SOURCE_BINANCE)
            ->setType(CoinPrice::TYPE_SOURCE)
            ->setDate(new DateTime());
    }
}
