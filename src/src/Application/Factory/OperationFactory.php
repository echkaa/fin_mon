<?php

namespace App\Application\Factory;

use App\Domain\Contract\Command\OperationFillCommandInterface;
use App\Domain\Contract\Entity\EntityInterface;
use App\Domain\Contract\Factory\OperationFactoryInterface;
use App\Domain\Entity\Operation;

class OperationFactory implements OperationFactoryInterface
{
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
            ->setType($command->getType());
    }
}
