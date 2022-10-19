<?php

namespace App\Application\Factory;

use App\Application\Service\UserService;
use App\Domain\Contract\Command\OperationFillCommandInterface;
use App\Domain\Contract\Entity\EntityInterface;
use App\Domain\Contract\Factory\OperationFactoryInterface;
use App\Domain\Entity\Operation;
use DateTime;

class OperationFactory implements OperationFactoryInterface
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    public function getInstance(): EntityInterface
    {
        return new Operation();
    }

    public function fillEntity(EntityInterface $entity, OperationFillCommandInterface $command): EntityInterface
    {
        return $entity
            ->setAmount($command->getAmount())
            ->setDescription($command->getDescription())
            ->setExternalCode($command->getExternalCode())
            ->setSource($command->getSource())
            ->setType($command->getType())
            ->setDate(new DateTime($command->getDate()))
            ->setUser($this->userService->getCurrentUser());
    }
}
