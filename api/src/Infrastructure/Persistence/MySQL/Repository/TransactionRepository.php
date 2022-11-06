<?php

namespace App\Infrastructure\Persistence\MySQL\Repository;

use App\Domain\Contract\Repository\TransactionRepositoryInterface;
use App\Domain\Entity\Transaction;

class TransactionRepository extends AbstractRepository implements TransactionRepositoryInterface
{
    function getEntityClassName(): string
    {
        return Transaction::class;
    }
}
