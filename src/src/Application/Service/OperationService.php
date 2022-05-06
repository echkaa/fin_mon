<?php

namespace App\Application\Service;

use App\Application\Command\Operation\Store\OperationStoreCommand;
use App\Application\Command\Operation\Update\OperationUpdateCommand;
use App\Application\Repository\OperationRepository;
use App\Domain\Entity\Operation;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

class OperationService extends AbstractCRUDService
{
    public function __construct(
        OperationRepository $entityRepository,
        ManagerRegistry $doctrine,
    ) {
        parent::__construct(
            $entityRepository,
            $doctrine
        );
    }

    public function storeByCommand(OperationStoreCommand $command): void
    {
        $operation = (new Operation())
            ->setAmount($command->getAmount())
            ->setDescription($command->getDescription())
            ->setExternalCode($command->getExternalCode())
            ->setSource($command->getSource())
            ->setType($command->getType());

        $this->store($operation);
    }

    /**
     * @throws Exception
     */
    public function updateByCommand(OperationUpdateCommand $command): void
    {
        $operation = $this->findById($command->getId())
            ->setAmount($command->getAmount())
            ->setDescription($command->getDescription())
            ->setExternalCode($command->getExternalCode())
            ->setSource($command->getSource())
            ->setType($command->getType());

        $this->update($operation);
    }
}
