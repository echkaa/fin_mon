<?php

namespace App\Domain\Contract\Repository;

use App\Domain\Contract\Entity\EntityInterface;

interface AbstractRepositoryInterface
{
    function store(EntityInterface $entity): void;

    function all(): array;

    function update(EntityInterface $entity): void;

    function delete(EntityInterface $entity): void;

    function findByOne(int $id): ?EntityInterface;

    function getEntityClassName(): string;
}
