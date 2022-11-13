<?php

namespace App\Application\Service;

use App\Domain\Contract\Factory\TransactionFactoryInterface;
use App\Domain\Contract\Repository\SpotCoinPriceRepositoryInterface;
use App\Domain\Contract\Repository\TransactionRepositoryInterface;
use App\Domain\Entity\DTO\BinanceBalanceCoin;
use App\Domain\Entity\DTO\BinanceCoinTransaction;
use App\Domain\Entity\Transaction;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;

class TransactionService
{
    public function __construct(
        private TransactionFactoryInterface $transactionFactory,
        private TransactionRepositoryInterface $transactionRepository,
        private UserService $userService,
        private SpotCoinPriceRepositoryInterface $coinPriceRepository,
    ) {
    }

    public function getLastTransactionsForCurrentUser(): ArrayCollection
    {
        return $this->transactionRepository->getLastTransactionByUser(
            $this->userService->getCurrentUser()
        );
    }

    public function updateMarketPriceOnTransactions(ArrayCollection $transactions): ArrayCollection
    {
        return $transactions->map(function (Transaction $transaction) {
            try {
                $price = $this->coinPriceRepository->find(
                    $transaction->getCoin()->getPairName()
                );
            } catch (Exception) {
            }

            return $transaction->setMarketPrice($price ?? 0);
        });
    }

    public function filterTransactionsByValue(ArrayCollection $transactions): ArrayCollection
    {
        return $transactions->filter(function (Transaction $transaction) {
            return $transaction->getTotalQuantity() * $transaction->getMarketPrice() > 10;
        });
    }

    public function fillFromBinanceBalanceCoinCollection(ArrayCollection $balanceCoins): void
    {
        $balanceCoins->map(function (BinanceBalanceCoin $balanceCoin) {
            $balanceCoin->getTransactions()->map(
                function (BinanceCoinTransaction $binanceTransaction) use ($balanceCoin) {
                    $transaction = $this->transactionFactory->fillEntityFromBinanceCoinTransaction(
                        $this->transactionFactory->getInstance(),
                        $balanceCoin->getCoin(),
                        $binanceTransaction
                    );

                    $this->transactionRepository->store($transaction);
                }
            );
        });
    }
}
