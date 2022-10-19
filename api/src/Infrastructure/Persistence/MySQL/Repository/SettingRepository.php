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
}
