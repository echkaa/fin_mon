<?php

namespace App\Domain\Contract\Encrypt;

interface EncryptInterface
{
    public function encode(string $privateKey, string $data): string;
}
