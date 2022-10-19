<?php

namespace App\Application\Factory;

use App\Domain\Contract\Encrypt\EncryptInterface;
use App\Domain\Entity\DTO\BinanceToken;

class TokenBinanceFactory
{
    private const MS_ACTIVE_SIGNATURE = 60000;
    private const TIMESTAMP_KEY = 'timestamp';
    private const SEC_ACTIVE_TOKEN_KEY = 'recvWindow';

    public function __construct(
        private EncryptInterface $encrypt,
    ) {
    }

    public function create(string $publicKey, string $privateKey, array $params): BinanceToken
    {
        $paramsHttp = $this->getHttpParams($params);

        return (new BinanceToken())
            ->setPublicKey($publicKey)
            ->setPrivateKey($privateKey)
            ->setParamsHttp($paramsHttp)
            ->setSignature(
                $this->encrypt->encode(
                    privateKey: $privateKey,
                    data: $paramsHttp,
                )
            );
    }

    private function getHttpParams(array $params): string
    {
        $sortParams = [
            self::TIMESTAMP_KEY => time() . "000",
            self::SEC_ACTIVE_TOKEN_KEY => self::MS_ACTIVE_SIGNATURE,
        ];

        $paramsHttp = http_build_query($params);
        $paramsHttp .= $paramsHttp ? '&' : '';
        $paramsHttp .= http_build_query($sortParams);

        return $paramsHttp;
    }
}
