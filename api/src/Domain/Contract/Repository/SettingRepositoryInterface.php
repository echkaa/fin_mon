<?php

namespace App\Domain\Contract\Repository;

interface SettingRepositoryInterface extends AbstractRepositoryInterface
{
    public function getMonobankNotNullList(): array;

    public function getBinanceKeysNotNullList(): array;
}
