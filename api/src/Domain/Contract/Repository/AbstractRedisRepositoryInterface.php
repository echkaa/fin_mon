<?php

namespace App\Domain\Contract\Repository;

interface AbstractRedisRepositoryInterface
{
    public function save(string $identifier, string $value): void;

    public function getPrefix(): string;

    public function find(string $identifier): string;
}
