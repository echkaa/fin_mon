<?php

namespace App\Domain\Contract\Service;

use App\Domain\Contract\Entity\EntityInterface;

interface CRUDOperationService
{
    function store(EntityInterface $entity): void;

    function findById(int $id): ?EntityInterface;

    function all(): array;

    function update(EntityInterface $entity): void;

    function delete(int $id): void;
}
