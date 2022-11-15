<?php

namespace App\Domain\Contract\Repository;

use DateTime;

interface CoinPriceRepositoryInterface extends AbstractRepositoryInterface
{
    public function deleteRowsToDateTime(DateTime $deletedTo): void;
}
