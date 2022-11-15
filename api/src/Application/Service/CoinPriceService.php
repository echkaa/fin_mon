<?php

namespace App\Application\Service;

use App\Domain\Contract\Factory\CoinPriceFactoryInterface;
use App\Domain\Contract\Repository\CoinPriceRepositoryInterface;
use App\Domain\Contract\Repository\CoinRepositoryInterface;
use App\Domain\Contract\Repository\FuturesCoinPriceRepositoryInterface;
use App\Domain\Entity\Coin;
use Exception;
use DateTime;

class CoinPriceService
{
    public function __construct(
        private CoinPriceFactoryInterface $coinPriceFactory,
        private CoinRepositoryInterface $coinRepository,
        private CoinPriceRepositoryInterface $coinPriceRepository,
        private FuturesCoinPriceRepositoryInterface $futuresCoinPriceRepository,
    ) {
    }

    public function storeFuturesCoinsPrice(): void
    {
        $coins = $this->coinRepository->all();

        array_map(
            function (Coin $coin) {
                try {
                    $coinPrice = $this->coinPriceFactory->fillEntityForBinanceFutures(
                        $this->coinPriceFactory->getInstance(),
                        $coin,
                        $this->futuresCoinPriceRepository->find($coin->getPairName()),
                    );

                    $this->coinPriceRepository->store($coinPrice);
                } catch (Exception) {
                }
            },
            $coins
        );
    }

    public function deleteOldFuturesCoinsPrice(DateTime $deletedTo): void
    {
        $this->coinPriceRepository->deleteRowsToDateTime($deletedTo);
    }
}
