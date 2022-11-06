<?php

namespace App\Application\Service;

use App\Domain\Contract\Repository\CoinPriceRepositoryInterface;
use App\Domain\Entity\DTO\BinanceAccount;
use App\Domain\Entity\DTO\BinanceBalanceCoin;
use App\Domain\Entity\DTO\BinanceCoinTransaction;
use Doctrine\Common\Collections\Collection;
use Exception;

class BinanceAccountCoinFillService
{
    public function __construct(
        private CoinPriceRepositoryInterface $coinPriceRepository
    ) {
    }

    public function fillFullStatCoinsByAccount(BinanceAccount $account)
    {
        $this->fillMarketPrice($account->getBalanceCoins());
        $this->fillRealPrice($account->getBalanceCoins());
    }

    public function fillMarketPrice(Collection $coins): Collection
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

    public function fillRealPrice(Collection $coins): Collection
    {
        return $coins->map(function (BinanceBalanceCoin $coin) {
            try {
                $coin->setFactPrice(
                    $this->getPriceFromCoinTransactions($coin)
                );
            } catch (Exception) {
            }
        });
    }

    private function getPriceFromCoinTransactions(BinanceBalanceCoin $coin): float
    {
        $quantity = $price = 0;
        $transactions = $coin->getTransactions();
        $indexStartCalc = $this->getStartIndex($coin);

        for ($i = $indexStartCalc; $i < $transactions->count(); $i++) {
            /* @var BinanceCoinTransaction $transaction */
            $transaction = $transactions->get($i);

            if ($transaction->getIsBuyer()) {
                $price = ($price * $quantity + $transaction->getPrice() * $transaction->getCount(
                        )) / ($quantity + $transaction->getCount());
            }

            $quantity += $transaction->getIsBuyerInt() * $transaction->getCount();
        }

        return $price;
    }

    private function getStartIndex(BinanceBalanceCoin $coin): int
    {
        $transactions = $coin->getTransactions();
        $indexStartCalc = $quantity = 0;

        for ($i = $transactions->count() - 1; $i >= 0; $i--) {
            /* @var BinanceCoinTransaction $transaction */
            $transaction = $transactions->get($i);

            $quantity += $transaction->getIsBuyerInt() * $transaction->getCount();

            if ($quantity >= 0 && $quantity * $coin->getMarketPrice() <= 10) {
                $indexStartCalc = $i + (int)$transaction->getIsBuyer();
                break;
            }
        }

        return $indexStartCalc;
    }
}
