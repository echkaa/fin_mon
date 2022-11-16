<?php

namespace App\Application\Factory;

use App\Domain\Contract\Factory\CoinPriceChangeFactoryInterface;
use App\Domain\Entity\Coin;
use App\Domain\Entity\CoinPriceChange;
use DateTime;

class CoinPriceChangeFactory implements CoinPriceChangeFactoryInterface
{
    public function getFuturesCoinPriceChangeFromOld(
        ?CoinPriceChange $oldEntity,
        Coin $coin,
        float $marketPrice,
        string $timeRange
    ): CoinPriceChange {
        $entity = $this->getInstance()
            ->setCoin($coin)
            ->setType(CoinPriceChange::TYPE_SOURCE)
            ->setSource(CoinPriceChange::SOURCE_BINANCE)
            ->setMarketPrice($marketPrice)
            ->setDate(new DateTime())
            ->setPreviousChange($oldEntity)
            ->setTimeRange($timeRange);

        return $entity->setChangePercent($this->getChangePercent($entity));
    }

    public function getInstance(): CoinPriceChange
    {
        return new CoinPriceChange();
    }

    private function getChangePercent(CoinPriceChange $entity): float
    {
        return $entity->getPreviousChange()
            ? (($entity->getMarketPrice() / $entity->getPreviousChange()->getMarketPrice()) * 100) - 100
            : 0;
    }
}
