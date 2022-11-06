<?php

namespace App\Infrastructure\Persistence\MySQL\Repository;

use App\Domain\Contract\Repository\SettingRepositoryInterface;
use App\Domain\Entity\Setting;

class SettingRepository extends AbstractRepository implements SettingRepositoryInterface
{
    function getEntityClassName(): string
    {
        return Setting::class;
    }

    public function getMonobankNotNullList(): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.monoBankToken is not null')
            ->getQuery()
            ->getResult();
    }

    public function getBinanceKeysNotNullList(): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.binancePublicKey is not null')
            ->andWhere('s.binancePrivateKey is not null')
            ->getQuery()
            ->getResult();
    }
}
