<?php

namespace App\Domain\Contract\Factory;

use App\Domain\Contract\Command\OperationFillCommandInterface;
use App\Domain\Entity\Operation;

interface OperationFactoryInterface
{
    public function getInstance(): Operation;

    public function fillEntityFromCommand(Operation $entity, OperationFillCommandInterface $command): Operation;

    public function fillEntityFromMonoBank(Operation $entity, array $data): Operation;
}
