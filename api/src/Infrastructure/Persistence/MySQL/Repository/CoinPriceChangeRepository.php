<?php

namespace App\Infrastructure\Persistence\MySQL\Repository;

use App\Domain\Contract\Repository\CoinPriceChangeRepositoryInterface;
use App\Domain\Entity\CoinPriceChange;
use DateTime;

class CoinPriceChangeRepository extends AbstractRepository implements CoinPriceChangeRepositoryInterface
{
    function getEntityClassName(): string
    {
        return CoinPriceChange::class;
    }

    public function deleteRowsToDateTime(DateTime $deletedTo): void
    {
        $this->createQueryBuilder('cpc')
            ->where('cpc.date < :deletedTo')
            ->setParameter('deletedTo', $deletedTo)
            ->delete()
            ->getQuery()
            ->execute();
    }

    public function getByTimeRange(string $timeRange): array
    {
        return $this->createQueryBuilder('cpc')
            ->select('cpc')
            ->leftJoin(
                'App\Domain\Entity\CoinPriceChange',
                'cpcc',
                'WITH',
                'cpc.coin = cpcc.coin AND cpc.id < cpcc.id'
            )
            ->leftJoin('cpc.coin', 'c')
            ->where('cpcc.id is null')
            ->andWhere('cpc.timeRange like :timeRange')
            ->setParameter('timeRange', $timeRange)
            ->groupBy('cpc.coin')
            ->orderBy('cpc.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
