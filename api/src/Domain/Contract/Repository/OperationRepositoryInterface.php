<?php

namespace App\Domain\Contract\Repository;

use DateTime;

interface OperationRepositoryInterface extends AbstractRepositoryInterface
{
    public function getStatisticByUser(int $userId): array;

    public function getExternalIdsFromTime(DateTime $dateTime): array;

    public function getByFilters(array $filters): array;
}
