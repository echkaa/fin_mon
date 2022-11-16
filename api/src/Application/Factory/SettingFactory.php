<?php

namespace App\Application\Factory;

use App\Application\Command\Setting\Update\UpdateCommand;
use App\Application\Service\UserService;
use App\Domain\Contract\Factory\SettingFactoryInterface;
use App\Domain\Entity\Setting;

class SettingFactory implements SettingFactoryInterface
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    public function getInstance(): Setting
    {
        return new Setting();
    }

    public function fillEntity(Setting $entity, UpdateCommand $command): Setting
    {
        return $entity
            ->setBinancePublicKey($command->getBinancePublicKey())
            ->setBinancePrivateKey($command->getBinancePrivateKey())
            ->setMonoBankToken($command->getMonoBankToken())
            ->setUser($this->userService->getCurrentUser());
    }
}
