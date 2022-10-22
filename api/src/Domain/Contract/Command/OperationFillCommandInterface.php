<?php

namespace App\Domain\Contract\Command;

interface OperationFillCommandInterface
{
    public function getAmount(): float;

    public function getType(): ?string;

    public function getDescription(): ?string;

    public function getExternalCode(): string;

    public function getDate(): string;
}
