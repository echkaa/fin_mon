<?php

namespace App\Application\Service;

use App\Application\Request\Binance\MyTradesRequest;
use App\Domain\Entity\DTO\BinanceBalanceCoin;
use App\Infrastructure\Persistence\Redis\Repository\CoinPriceRepository;
use Doctrine\Common\Collections\Collection;
use Exception;

class BinanceCoinService
{
    public function __construct(
        private MyTradesRequest $myTradesRequest,
        private CoinPriceRepository $coinPriceRepository,
    ) {
    }

    public function filterCoinsByList(Collection $coins, ?array $coinNeedList): Collection
    {
        return $coins->filter(
            function (BinanceBalanceCoin $coin) use ($coinNeedList) {
                return $coinNeedList === null || in_array($coin->getName(), $coinNeedList);
            }
        );
    }

    public function fillMarketPrice(Collection $coins): Collection
    {
        return $coins->map(function (BinanceBalanceCoin $coin) {
            try {
                return $coin->setMarketPrice(
                    (float)$this->coinPriceRepository->find($coin->getPairName())
                );
            } catch (Exception) {
            }

            return $coin->setMarketPrice(1);
        });
    }

    public function fillRealPrice(Collection $coins): Collection
    {
        return $coins->map(function (BinanceBalanceCoin $coin) {
            try {
                $allTrade = $this->myTradesRequest->sendRequest($coin->getPairName());
                $price = $indexStartCalc = $quantity = 0;

                for ($i = count($allTrade) - 1; $i >= 0; $i--) {
                    $quantity += ($allTrade[$i]['isBuyer'] ? 1 : -1) * $allTrade[$i]['qty'];

                    if ($quantity >= 0 && $quantity * $coin->getMarketPrice() <= 10) {
                        $indexStartCalc = $i + ($allTrade[$i]['isBuyer'] ? 0 : 1);
                        break;
                    }
                }

                $quantity = 0;

                for ($i = $indexStartCalc; $i < count($allTrade); $i++) {
                    if ($allTrade[$i]['isBuyer']) {
                        $price = ($price * $quantity + $allTrade[$i]['price'] * $allTrade[$i]['qty']) / ($quantity + $allTrade[$i]['qty']);
                    }

                    $quantity += ($allTrade[$i]['isBuyer'] ? 1 : -1) * $allTrade[$i]['qty'];
                }

                $coin->setFactPrice($price);
            } catch (Exception) {
            }
        });
    }
}
