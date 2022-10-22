<?php

namespace App\Domain\Contract\Repository;

interface SettingRepositoryInterface extends AbstractRepositoryInterface
{
    public function getNotNullList(): array;
}
