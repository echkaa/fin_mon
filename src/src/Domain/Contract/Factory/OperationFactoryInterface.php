<?php

namespace App\Domain\Contract\Factory;

use App\Domain\Contract\Command\OperationFillCommandInterface;
use App\Domain\Contract\Entity\EntityInterface;

interface OperationFactoryInterface
{
    public function getInstance(): EntityInterface;

    public function fillEntity(EntityInterface $entity, OperationFillCommandInterface $command): EntityInterface;
}
