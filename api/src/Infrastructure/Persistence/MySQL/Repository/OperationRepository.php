<?php

namespace App\Infrastructure\Persistence\MySQL\Repository;

use App\Domain\Contract\Repository\OperationRepositoryInterface;
use App\Domain\Entity\Operation;
use DateTime;

class OperationRepository extends AbstractRepository implements OperationRepositoryInterface
{
    public function getEntityClassName(): string
    {
        return Operation::class;
    }

    public function getStatisticByUser(int $userId): array
    {
        return $this->createQueryBuilder('op')
            ->select([
                'SUM(op.amount) as summa',
                'COUNT(op.id) as count_operation',
            ])
            ->where('op.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getArrayResult();
    }

    public function getExternalIdsFromTime(DateTime $dateTime): array
    {
        return $this->createQueryBuilder('op')
            ->select([
                'op.externalId',
            ])
            ->where("op.date >= :dateTime")
            ->andWhere("op.externalId is not null")
            ->setParameter('dateTime', $dateTime)
            ->getQuery()
            ->getArrayResult();
    }
}
