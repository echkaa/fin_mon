<?php

namespace App\Domain\Contract\Repository;

interface OperationRepositoryInterface extends AbstractRepositoryInterface
{
    public function getStatistic(): array;
}
