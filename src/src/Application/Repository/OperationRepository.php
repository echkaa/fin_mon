<?php

namespace App\Application\Repository;

use App\Domain\Contract\Repository\OperationRepositoryInterface;
use App\Domain\Entity\Operation;

class OperationRepository extends AbstractRepository implements OperationRepositoryInterface
{
    public function getEntityClassName(): string
    {
        return Operation::class;
    }

    public function getStatistic(): array
    {
        return $this->createQueryBuilder('op')
            ->select([
                'SUM(op.amount) as summa',
                'COUNT(op.id) as count_operation',
            ])
            ->getQuery()
            ->getArrayResult();
    }
}
