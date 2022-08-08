<?php

namespace App\Application\Encrypt;

use App\Domain\Contract\Encrypt\EncryptInterface;

class HMACSHA256Encrypt implements EncryptInterface
{
    private const ALGO_SHA256 = 'sha256';

    public function encode(string $privateKey, string $data): string
    {
        return hash_hmac(
            algo: self::ALGO_SHA256,
            data: $data,
            key: $privateKey,
        );
    }
}
