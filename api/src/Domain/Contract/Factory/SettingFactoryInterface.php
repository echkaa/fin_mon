<?php

namespace App\Domain\Contract\Factory;

use App\Application\Command\Setting\Update\UpdateCommand;
use App\Domain\Entity\Setting;

interface SettingFactoryInterface
{
    public function getInstance(): Setting;

    public function fillEntity(Setting $entity, UpdateCommand $command): Setting;
}
