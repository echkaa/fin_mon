<?php

namespace App\Application\Service;

use App\Domain\Contract\Factory\CoinPriceChangeFactoryInterface;
use App\Domain\Contract\Repository\CoinPriceChangeRepositoryInterface;
use App\Domain\Contract\Repository\CoinRepositoryInterface;
use App\Domain\Contract\Repository\FuturesCoinPriceRepositoryInterface;
use App\Domain\Entity\Coin;
use App\Domain\Entity\CoinPriceChange;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use DateTime;

class CoinPriceChangeService
{
    public function __construct(
        private CoinPriceChangeRepositoryInterface $coinPriceChangeRepository,
        private CoinRepositoryInterface $coinRepository,
        private FuturesCoinPriceRepositoryInterface $futuresCoinPriceRepository,
        private CoinPriceChangeFactoryInterface $coinPriceChangeFactory,
    ) {
    }

    public function storeFuturesCoinPriceChangeByTimeRange(string $timeRange): void
    {
        $oldCoinPriceChanges = $this->getLastCoinPriceChangeByTimeRange($timeRange);
        $coins = $this->coinRepository->all();

        array_map(
            function (Coin $coin) use ($oldCoinPriceChanges, $timeRange) {
                try {
                    $coinPriceChange = $this->coinPriceChangeFactory->getFuturesCoinPriceChangeFromOld(
                        $oldCoinPriceChanges->get($coin->getName()),
                        $coin,
                        $this->futuresCoinPriceRepository->find($coin->getPairName()),
                        $timeRange,
                    );

                    $this->coinPriceChangeRepository->store($coinPriceChange);
                } catch (Exception) {
                }
            },
            $coins
        );
    }

    public function getLastCoinPriceChangeByTimeRange(string $timeRange): ArrayCollection
    {
        $oldCoinPriceChanges = new ArrayCollection();

        array_map(
            function (CoinPriceChange $coinPriceChange) use ($oldCoinPriceChanges) {
                $oldCoinPriceChanges->set(
                    $coinPriceChange->getCoin()->getName(),
                    $coinPriceChange,
                );
            },
            $this->coinPriceChangeRepository->getByTimeRange($timeRange),
        );

        return $oldCoinPriceChanges;
    }

    public function deleteOldFuturesCoinsPrice(DateTime $deletedTo): void
    {
        $this->coinPriceChangeRepository->deleteRowsToDateTime($deletedTo);
    }
}
