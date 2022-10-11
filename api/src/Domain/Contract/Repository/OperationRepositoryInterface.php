<?php

namespace App\Domain\Contract\Repository;

interface OperationRepositoryInterface extends AbstractRepositoryInterface
{
    public function getStatisticByUser(int $userId): array;
}
