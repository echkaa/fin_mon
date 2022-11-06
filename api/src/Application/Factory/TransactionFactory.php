<?php

namespace App\Application\Factory;

use App\Application\Service\UserService;
use App\Domain\Entity\Transaction;
use App\Domain\Entity\Coin;
use App\Domain\Entity\DTO\BinanceCoinTransaction;
use App\Domain\Contract\Factory\TransactionFactoryInterface;

class TransactionFactory implements TransactionFactoryInterface
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    public function getInstance(): Transaction
    {
        return new Transaction();
    }

    public function fillEntityFromBinanceCoinTransaction(
        Transaction $entity,
        Coin $coin,
        BinanceCoinTransaction $coinTransaction,
    ): Transaction {
        return $entity->setSetting($this->userService->getCurrentUser()->getSetting())
            ->setCoin($coin)
            ->setMarketPrice($coinTransaction->getMarketPrice())
            ->setQuantity($coinTransaction->getQuantity())
            ->setFactPrice($coinTransaction->getFactPrice())
            ->setTotalQuantity($coinTransaction->getTotalQuantity())
            ->setIsBuyer($coinTransaction->getIsBuyer())
            ->setDate($coinTransaction->getDate())
            ->setSource(Transaction::BINANCE_SOURCE)
            ->setSourceId($coinTransaction->getId());
    }
}
