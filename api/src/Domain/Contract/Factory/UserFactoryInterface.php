<?php

namespace App\Domain\Contract\Factory;

use App\Application\Command\Auth\Registration\RegistrationCommand;
use App\Domain\Contract\Entity\EntityInterface;
use App\Domain\Entity\User;

interface UserFactoryInterface
{
    public function getInstance(): User;

    public function fillEntity(User $entity, RegistrationCommand $command): User;
}
