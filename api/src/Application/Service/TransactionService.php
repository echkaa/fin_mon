<?php

namespace App\Application\Service;

use App\Domain\Contract\Factory\TransactionFactoryInterface;
use App\Domain\Contract\Repository\TransactionRepositoryInterface;
use App\Domain\Entity\DTO\BinanceBalanceCoin;
use App\Domain\Entity\DTO\BinanceCoinTransaction;
use Doctrine\Common\Collections\ArrayCollection;

class TransactionService
{
    public function __construct(
        private TransactionFactoryInterface $transactionFactory,
        private TransactionRepositoryInterface $transactionRepository,
    ) {
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
