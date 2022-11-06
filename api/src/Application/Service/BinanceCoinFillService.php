<?php

namespace App\Application\Service;

use App\Application\Request\Binance\CoinListRequest;
use App\Domain\Contract\Factory\CoinFactoryInterface;
use App\Domain\Contract\Repository\CoinRepositoryInterface;
use App\Domain\Entity\Coin;
use App\Domain\Exception\EntityExistException;

class BinanceCoinFillService
{
    public function __construct(
        private CoinListRequest $coinListRequest,
        private CoinFactoryInterface $coinFactory,
        private CoinRepositoryInterface $coinRepository,
        private BinanceAllCoinService $allCoinService,
    ) {
    }

    public function fillCoinsFromBinance(): void
    {
        $coinList = $this->coinListRequest->sendRequest();

        foreach ($coinList as $coin) {
            try {
                $coinEntity = $this->coinFactory->fillEntityFromBinance(
                    entity: $this->coinFactory->getInstance(),
                    data: $coin,
                );

                $this->checkOnExist($coinEntity);

                $this->coinRepository->store($coin);
            } catch (EntityExistException) {
            }
        }
    }

    /**
     * @throws EntityExistException
     * */
    private function checkOnExist(Coin $coin): void
    {
        $coin = $this->allCoinService->getCoinByName($coin->getName());

        if ($coin) {
            throw new EntityExistException();
        }
    }
}
