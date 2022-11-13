<?php

namespace App\Application\Factory\DTO;

use App\Domain\Entity\DTO\BinanceCoinTransaction;
use App\Domain\Entity\Transaction;
use Doctrine\Common\Collections\ArrayCollection;

class BinanceTransactionFactory
{
    public function getTransactionListFromBinanceTrades(array $trades): ArrayCollection
    {
        $transactions = new ArrayCollection();

        array_map(
            function ($trade) use ($transactions) {
                $transactions->add($this->getTransactionFromBinanceTrade($trade));
            },
            $trades
        );

        return $transactions;
    }

    private function getTransactionFromBinanceTrade(array $trade): BinanceCoinTransaction
    {
        return (new BinanceCoinTransaction())
            ->setQuantity((float)$trade['qty'])
            ->setMarketPrice((float)$trade['price'])
            ->setTime((int)($trade['time'] / 1000))
            ->setIsBuyer($trade['isBuyer'])
            ->setId($trade['id']);
    }

    public function getBinanceTransactionFromTransaction(Transaction $transaction): BinanceCoinTransaction
    {
        return (new BinanceCoinTransaction())
            ->setQuantity($transaction->getQuantity())
            ->setTotalQuantity($transaction->getTotalQuantity())
            ->setMarketPrice($transaction->getMarketPrice())
            ->setTime($transaction->getDate()->format('U'))
            ->setIsBuyer($transaction->getIsBuyer())
            ->setId($transaction->getSourceId());
    }
}
