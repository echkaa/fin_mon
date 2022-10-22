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

    public function getInstance(): Operation
    {
        return new Operation();
    }

    public function fillEntityFromCommand(Operation $entity, OperationFillCommandInterface $command): Operation
    {
        return $entity
            ->setAmount($command->getAmount())
            ->setDescription($command->getDescription())
            ->setExternalCode($command->getExternalCode())
            ->setType($command->getType())
            ->setDate(new DateTime($command->getDate()))
            ->setUser($this->userService->getCurrentUser());
    }

    public function fillEntityFromMonoBank(Operation $entity, array $data): Operation
    {
        return $entity
            ->setAmount(($data['amount'] * -1) / 100)
            ->setDescription($data['description'])
            ->setExternalId($data['id'])
            ->setExternalCode(Operation::EXTERNAL_CODE_MONOBANK)
            ->setDate((new DateTime())->setTimestamp($data['time']))
            ->setUser($this->userService->getCurrentUser());
    }
}
