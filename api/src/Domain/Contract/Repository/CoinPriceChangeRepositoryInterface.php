<?php

namespace App\Domain\Contract\Repository;

use DateTime;

interface CoinPriceChangeRepositoryInterface extends AbstractRepositoryInterface
{
    public function getByTimeRange(string $timeRange): array;

    public function deleteRowsToDateTime(DateTime $deletedTo): void;
}
