<?php

namespace App\Infrastructure\Persistence\MySQL\Repository;

use App\Domain\Contract\Repository\CoinPriceRepositoryInterface;
use App\Domain\Entity\CoinPrice;
use DateTime;

class CoinPriceRepository extends AbstractRepository implements CoinPriceRepositoryInterface
{
    function getEntityClassName(): string
    {
        return CoinPrice::class;
    }

    public function deleteRowsToDateTime(DateTime $deletedTo): void
    {
        $this->createQueryBuilder('cp')
            ->where('cp.date < :deletedTo')
            ->setParameter('deletedTo', $deletedTo)
            ->delete()
            ->getQuery()
            ->execute();
    }
}
