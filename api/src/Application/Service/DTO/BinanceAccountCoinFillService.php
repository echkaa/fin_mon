<?php

namespace App\Application\Service\DTO;

use App\Domain\Contract\Repository\SpotCoinPriceRepositoryInterface;
use App\Domain\Entity\DTO\BinanceAccount;
use App\Domain\Entity\DTO\BinanceBalanceCoin;
use App\Domain\Entity\DTO\BinanceCoinTransaction;
use Doctrine\Common\Collections\Collection;
use Exception;

class BinanceAccountCoinFillService
{
    public function __construct(
        private SpotCoinPriceRepositoryInterface $coinPriceRepository
    ) {
    }

    public function fillFullStatCoinsByAccount(BinanceAccount $account): void
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
                $price = ($price * $quantity + $transaction->getMarketPrice() * $transaction->getQuantity(
                        )) / ($quantity + $transaction->getQuantity());
            }

            $quantity += $transaction->getIsBuyerInt() * $transaction->getQuantity();

            $transaction->setTotalQuantity($quantity)
                ->setFactPrice($price);
        }

        return $price;
    }

    private function getStartIndex(BinanceBalanceCoin $coin): int
    {
        $transactions = $coin->getTransactions();
        $indexStartCalc = $quantity = 0;

        if ($transactions->first() instanceof BinanceCoinTransaction
            && $transactions->first()->getTotalQuantity() > 0) {
            return $indexStartCalc;
        }

        for ($i = $transactions->count() - 1; $i >= 0; $i--) {
            /* @var BinanceCoinTransaction $transaction */
            $transaction = $transactions->get($i);

            $quantity += $transaction->getIsBuyerInt() * $transaction->getQuantity();

            if ($quantity >= 0 && $quantity * $coin->getMarketPrice() <= 10) {
                $indexStartCalc = $i + (int)$transaction->getIsBuyer();
                break;
            }
        }

        return $indexStartCalc;
    }
}
