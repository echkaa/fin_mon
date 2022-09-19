<?php

namespace App\Domain\Contract\Command;

interface OperationFillCommandInterface
{
    public function getAmount(): float;

    public function getType(): ?string;

    public function getSource(): ?string;

    public function getDescription(): ?string;

    public function getExternalCode(): string;
}
