<?php

namespace App\Application\Service;

use App\Application\Factory\DTO\BinanceAccountFactory;
use App\Application\Request\Binance\AccountBinanceRequest;
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
        private AccountBinanceRequest $accountBinanceRequest,
        private BinanceAccountFactory $binanceAccountFactory,
    ) {
    }

    public function getStatisticCoins(array $coinList = []): Collection
    {
        $accountData = $this->accountBinanceRequest->sendRequest();

        $account = $this->binanceAccountFactory->create($accountData);

        $account->setBalanceCoins(
            $this->filterCoinsByList(
                coins: $account->getBalanceCoins(),
                coinNeedList: $coinList,
            )
        );

        $this->fillMarketPrice($account->getBalanceCoins());
        $this->fillRealPrice($account->getBalanceCoins());

        return $this->filterCoins($account->getBalanceCoins());
    }

    private function filterCoins(Collection $coins): Collection
    {
        return $coins->filter(
            function (BinanceBalanceCoin $coin) {
                return $coin->getPNL() != 0 && $coin->getFactPrice() != 1;
            }
        );
    }

    private function filterCoinsByList(Collection $coins, array $coinNeedList): Collection
    {
        return $coins->filter(
            function (BinanceBalanceCoin $coin) use ($coinNeedList) {
                return empty($coinNeedList) || in_array($coin->getName(), $coinNeedList);
            }
        );
    }

    private function fillMarketPrice(Collection $coins): Collection
    {
        return $coins->map(function (BinanceBalanceCoin $coin) {
            try {
                return $coin->setMarketPrice(
                    (float)$this->coinPriceRepository->find($coin->getPairName())
                );
            } catch (Exception) {
                return $coin->setMarketPrice(1);
            }
        });
    }

    private function fillRealPrice(Collection $coins): Collection
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
