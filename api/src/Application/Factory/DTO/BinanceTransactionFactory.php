<?php

namespace App\Application\Factory\DTO;

use App\Domain\Entity\DTO\BinanceCoinTransaction;
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
            ->setCount((float)$trade['qty'])
            ->setPrice((float)$trade['price'])
            ->setTime($trade['time'])
            ->setIsBuyer($trade['isBuyer']);
    }
}
