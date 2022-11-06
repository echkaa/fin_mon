<?php

namespace App\Domain\Contract\Factory;

use App\Domain\Entity\Transaction;
use App\Domain\Entity\Coin;
use App\Domain\Entity\DTO\BinanceCoinTransaction;

interface TransactionFactoryInterface
{
    public function getInstance(): Transaction;

    public function fillEntityFromBinanceCoinTransaction(
        Transaction $entity,
        Coin $coin,
        BinanceCoinTransaction $coinTransaction,
    ): Transaction;
}
